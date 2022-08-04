<?php

namespace App\Modules\Contact;

use App\Libraries\Crud\CrudService;

class ContactService extends CrudService
{
    protected array $allowedRelations = [];

    public function __construct(ContactRepository $repo)
    {
        parent::__construct($repo);
    }

    /**
     * Save property contacts
     */
    public function saveContact(array $contactData, bool $isUpdate = false): ?Contact
    {
        if (empty($contactData['primary_phone'])) {
            return null;
        }

        if (empty($contactData['id'])) {
            $contact = $this->repo->getOneWhere(function ($query) use ($contactData) {
                $query->withTrashed()->where('primary_phone', $contactData['primary_phone']);
            });
        } else {
            $contact = $this->repo->getOneWithTrashed($contactData['id']);
        }

        if (!$contact) {
            return $this->repo->createOne($contactData);
        }

        $isDifferent = $contact->primary_phone !== $contactData['primary_phone']
            && $contact->name !== $contactData['name'];

        if ($isDifferent) {
            return $this->repo->createOne($contactData);
        }

        if ($contact->deleted_at === null && !$isUpdate) {
            return $this->repo->updateOne($contact, [
                ...$contactData,
                'deleted_at' => null
            ]);
        }

        return $this->repo->updateOne($contact, $contactData);
    }
}
