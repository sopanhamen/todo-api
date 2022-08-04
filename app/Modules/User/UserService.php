<?php

namespace App\Modules\User;

use App\Libraries\Crud\CrudService;
use App\Modules\Contact\ContactService;
use App\Modules\FileUpload\FileUploadService;
use App\Modules\Role\Role;
use App\Modules\UserProfile\UserProfile;
use App\Modules\UserProfile\UserProfileRepository;
use App\Modules\UserTeam\UserTeamService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserService extends CrudService
{
    protected UserRepository $userRepository;
    protected UserProfileRepository $profileRepository;
    protected ContactService $contactService;
    protected UserTeamService $userTeamService;
    private FileUploadService $fileUploadService;

    protected array $allowedRelations = [
        'profile', 'profile.contact', 'profile.company', 'teams', 'roles'
    ];

    protected array $filterable = [
        'name' => 'name',
        'email' => 'email',
        'phone' => 'phone',
        'role_id' => 'roles.id',
        'company_id' => 'profile.company_id',
        'company_branch_id' => 'profile.company_branch_id',
        'team_id' => 'teams.id',
        'show_on_website' => 'show_on_website',
    ];

    public function __construct(
        UserRepository $repo,
        UserProfileRepository $profileRepo,
        ContactService $contactService,
        UserTeamService $userTeamService,
        FileUploadService $fileUploadService
    ) {
        parent::__construct($repo);

        $this->userRepository = $repo;
        $this->profileRepository = $profileRepo;
        $this->userTeamService = $userTeamService;
        $this->contactService = $contactService;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param array $data
     */
    private function formatUserData(array $data): array
    {
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        return [
            ...$data,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ];
    }

    /**
     * Create one user
     *
     * @param array $payload
     * @return null|User
     */
    public function createOne(array $payload): ?User
    {
        return DB::transaction(function () use ($payload) {
            $user = $this->userRepository->createOne(
                $this->formatUserData($payload)
            );

            if (!empty($payload['roles'])) {
                $roles = array_map(fn ($role) => new Role($role), $payload['roles']);
                $user->assignRole($roles);
            }

            $this->userTeamService->assignToUser($user, $payload['teams']);

            $contact = $this->contactService->saveContact($payload['profile']['contact']);

            $picture = $this->saveProfilePicture(null, $payload['profile']['profile_picture']);
            $profile = $this->profileRepository->createOne([
                ...$payload['profile'],
                'profile_picture' => $picture,
                'profile_picture_disk' => config('filesystems.default'),
                'user_id' => $user->id,
                'contact_id' => $contact->id
            ]);
            $user->setRelation('profile', $profile);

            return $user;
        });
    }

    /**
     * Update one record
     *
     * @param string|int $id
     * @param array $payload
     * @param string $field (default = "id")
     * @return null|User
     */
    public function updateOne(string|int $id, array $payload, string $idColumn = null): ?User
    {
        return DB::transaction(function () use ($id, $idColumn, $payload) {
            $user = $this->userRepository->updateOne(
                $this->repo->getOneOrFail($id, $idColumn),
                $this->formatUserData($payload)
            );

            if ($user->isSuperAdmin()) {
                abort(403, 'Not allowed to update Super Admin');
            }

            if (!empty($payload['roles'])) {
                $roles = array_map(fn ($role) => new Role($role), $payload['roles']);
                $user->syncRoles($roles);
            }

            if (!empty($payload['teams'])) {
                $this->userTeamService->assignToUser($user, $payload['teams']);
            }

            $contact = $this->contactService->saveContact($payload['profile']['contact']);

            $profile = $this->profileRepository->getOneWhere(['user_id' => $user->id]);
            $picture = $this->saveProfilePicture($profile, $payload['profile']['profile_picture']);
            $profile = $this->profileRepository->updateOne($profile, [
                ...$payload['profile'],
                'profile_picture' => $picture,
                'profile_picture_disk' => config('filesystems.default'),
                'user_id' => $user->id,
                'contact_id' => $contact->id
            ]);

            return $user;
        });
    }

    /**
     * @param ?Profile $profile
     * @param null|array $tempPath
     * @return mixed
     */
    public function saveProfilePicture(?UserProfile $profile, ?array $tempPath): mixed
    {
        // new profile, no image
        if (!$profile && empty($tempPath)) {
            return null;
        }

        // is old image, use old image
        if (!empty($tempPath['url']) && !empty($tempPath['path'])) {
            return $tempPath['path'];
        }

        // new image for profile
        if ($profile && !empty($tempPath['path'])) {
            if ($profile->profile_picture) {
                $this->fileUploadService->delete($profile->profile_picture);
            }

            return $this->fileUploadService->moveToRealPath($tempPath['path'], 'user/');
        }

        // profile has no image, no image received from form
        if ($profile && empty($tempPath['path'])) {
            if ($profile->profile_picture) {
                $this->fileUploadService->delete($profile->profile_picture);
            }

            return null;
        }

        return $this->fileUploadService->moveToRealPath($tempPath['path'], 'user/');
    }

    /**
     * @return EloquentCollection
     */
    public function getTeammates(User $user): EloquentCollection
    {
        return $this->userRepository->getTeammateUsers($user->id);
    }

    public function getBasicProfile(string|User $user): ?UserProfile
    {
        return $this->profileRepository->getBasicProfile($user);
    }

    public static function basicProfile(string|User $user): ?UserProfile
    {
        return app()->call('\App\Modules\User\UserService@getBasicProfile', ['user' => $user]);
    }

    public function getOneByEmail(string $email)
    {
        $user = $this->userRepository->getOneWhere(['email' => $email]);
        if (empty($user)) {
            abort(404, 'Invalid User');
        }

        return $user;
    }

    /**
     * Delete one record by model
     *
     * @param User $model
     * @return null|User
     */
    public function deleteModel(Model $user): ?User
    {
        if ($user->isSuperAdmin()) {
            abort(403, 'Not allowed to delete Super Admin');
        }

        return $this->repo->deleteOne($user);
    }
}
