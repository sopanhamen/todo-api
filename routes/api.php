<?php

use App\Modules\Auth\AuthController;
use App\Modules\Bank\BankController;
use App\Modules\Role\RoleController;
use App\Modules\User\UserController;
use App\Modules\Agent\AgentController;
use App\Modules\Client\ClientController;
use App\Modules\Common\ResourceController;
use App\Modules\Commune\CommuneController;
use App\Modules\Company\CompanyController;
use App\Modules\Contact\ContactController;
use App\Modules\Country\CountryController;
use App\Modules\Listing\ListingController;
use App\Modules\Project\ProjectController;
use App\Modules\Setting\SettingController;
use App\Modules\District\DistrictController;
use App\Modules\Facility\FacilityController;
use App\Modules\Property\PropertyController;
use App\Modules\Province\ProvinceController;
use App\Modules\UserTeam\UserTeamController;
use App\Modules\Dashboard\DashboardController;
use App\Modules\Developer\DeveloperController;
use App\Modules\BankBranch\BankBranchController;
use App\Modules\ClientType\ClientTypeController;
use App\Modules\FileUpload\FileUploadController;
use App\Modules\SiteInquiry\SiteInquiryController;
use App\Modules\Property\PropertyDocumentController;
use App\Modules\PropertyType\PropertyTypeController;
use App\Modules\ClientPayment\ClientPaymentController;
use App\Modules\CompanyBranch\CompanyBranchController;
use App\Modules\PropertyVisit\PropertyVisitController;
use App\Modules\DevelopmentType\DevelopmentTypeController;
use App\Modules\ClientRequirement\ClientRequirementController;
use App\Modules\PropertyHistory\PropertyHistoryController;
use App\Modules\ContactCompany\ContactCompanyController;
use App\Modules\PropertyNegotiation\PropertyNegotiationController;
use App\Modules\Card\CardController;

/**
 * If user access /api/logs, redirect to /telescope
 */
$router->get('/logs', fn () => redirect('/telescope'))->middleware('auth:web');

/**
 * Auth module
 */
$router->group(['prefix' => 'auth'], function ($router) {
    // $router->post('register', [AuthController::class, 'register']);
    $router->post('/login', [AuthController::class, 'login']);
    $router->post('/logout', [AuthController::class, 'logout']);
    $router->get('/me', [AuthController::class, 'me']);
    $router->get('/permissions', [AuthController::class, 'permissions']);
    $router->put('/update-profile', [AuthController::class, 'updateProfile']);
});

$router->post('/forget-password', [AuthController::class, 'forgetPassword']);
$router->post('/update-password', [AuthController::class, 'updatePassword']);

// Verify User
$router->get('/verify', [UserController::class, 'verify'])->name('users.verify');

/**
 * Property module
 */
$router->controller(ListingController::class)->group(function ($router) {
    $router->get('/listings', 'index')->name('listings.index');
    $router->get('/listings/summaries', 'summarize')->name('listings.summarize');
    $router->get('/listings/{property}', 'show')->name('listings.show');
});

$router->controller(PropertyDocumentController::class)->group(function ($router) {
    $router->post('/properties/sample-excel', 'exportSampleExcel')->name('listings.exportSampleExcel');
    $router->get('/properties/{property}/documents', 'index');
    $router->get('/properties/{property}/documents/{document}', 'show');
});

$router->controller(PropertyController::class)->prefix('/properties')->group(function ($router) {
    $router->get('/{property}/contacts', 'getContacts');
    $router->post('/transfer', 'transfer')->name('properties.transfer');
    $router->post('/{property}/restore', 'restore')->name('properties.restore');
    $router->post('/{property}/approve', 'approve')->name('properties.approve');
    $router->post('/{property}/publish', 'publish')->name('properties.publish');
    $router->post('/create-many', 'storeMany')->name('properties.create.many');
    $router->delete('/{property}/document/{image}', 'deleteDocument')->name('properties.delete-document');
    $router->delete('/{property}/image/{image}', 'deleteImage')->name('properties.delete-image');
    $router->get('/trash', 'trash')->name('property.trash');
    $router->post('/{property}/restore', 'restore')->name('property.restore');
    $router->get('/maps', 'maps')->name('properties.maps');
});

$router->apiResource('/properties', PropertyController::class);

$router->controller(PropertyTypeController::class)->prefix('/property-types')->group(function ($router) {
    $router->post('/exports', 'exports')->name('property_types.exports');
    $router->get('/trash', 'trash')->name('property_type.trash');
    $router->post('/{propertyType}/restore', 'restore')->name('property_type.restore');
});
$router->apiResource('/property-types', PropertyTypeController::class);

$router->apiResource('/property-visits', PropertyVisitController::class);
$router->apiResource('/property-negotiations', PropertyNegotiationController::class);

/**
 * Property History
 */
// $router->apiResource('/property-histories', PropertyHistoryController::class);

/**
 * User module
 */
$router->apiResource('/users/roles', RoleController::class);
$router->put('/users/roles', [RoleController::class, 'updateMultiple'])->name('roles.updateMultiple');
$router->post('/users/roles/{role}/restore', [RoleController::class, 'restore'])->name('roles.restore');

$router->controller(UserController::class)->group(function ($router) {
    $router->get('/users/teammates', 'teammates')->name('users.teammates');
    $router->post('/users/{user}/restore', 'restore')->name('users.restore');
});

$router->controller(UserController::class)->prefix('/users')->group(function ($router) {
    $router->get('/trash', 'trash')->name('user.trash');
    $router->post('/{user}/restore', 'restore')->name('user.restore');
});
$router->apiResource('/users', UserController::class);

$router->apiResource('/user-teams', UserTeamController::class);

$router->apiResource('/agents', AgentController::class)->except(['store', 'update', 'delete']);

/**
 * Location module
 */
$router->apiResource('/countries', CountryController::class);
$router->post('/countries/exports', [CountryController::class, 'exports'])->name('countries.exports');
$router->apiResource('/provinces', ProvinceController::class);
$router->post('/provinces/exports', [ProvinceController::class, 'exports'])->name('provinces.exports');
$router->apiResource('/districts', DistrictController::class);
$router->post('/districts/exports', [DistrictController::class, 'exports'])->name('districts.exports');
$router->apiResource('/communes', CommuneController::class);
$router->post('/communes/exports', [CommuneController::class, 'exports'])->name('communes.exports');

/**
 * Project module
 */
$router->controller(ProjectController::class)->prefix('/projects')->group(function ($router) {
    $router->post('/exports', 'exports')->name('projects.exports');
    $router->get('/trash', 'trash')->name('projects.trash');
    $router->post('/{projects}/restore', 'restore')->name('projects.restore');
});
$router->apiResource('/projects', ProjectController::class);

/**
 * Companies module
 */
$router->controller(CompanyBranchController::class)->prefix('/companies/branches')->group(function ($router) {
    $router->get('/trash', 'trash');
    $router->post('/{companyBranch}/restore', 'restore')->name('companyBranch.restore');
});

$router->apiResource('/companies/branches', CompanyBranchController::class);
$router->apiResource('/companies', CompanyController::class);

/**
 * Banks and Bank branches module
 */
$router->name('bank_branch.')->group(function ($router) {
    $router->apiResource('/banks/branches', BankBranchController::class);
});
$router->apiResource('/banks', BankController::class);

/**
 * Client Type module
 */
$router->controller(ClientTypeController::class)->prefix('/client-types')->group(function ($router) {
    $router->post('/exports', 'exports')->name('client_types.exports');
    $router->get('/trash', 'trash')->name('client_type.trash');
    $router->post('/{clientType}/restore', 'restore')->name('client_type.restore');
});
$router->apiResource('/client-types', ClientTypeController::class);

/**
 * Development Module
 */
$router->controller(DevelopmentTypeController::class)->prefix('/development-types')->group(function ($router) {
    $router->post('/exports', 'exports')->name('development_types.exports');
    $router->get('/trash', 'trash')->name('development_type.trash');
    $router->post('/{developmentType}/restore', 'restore')->name('development_type.restore');
});
$router->apiResource('/development-types', DevelopmentTypeController::class);

/**
 * Developer Module
 */
$router->controller(DeveloperController::class)->prefix('/developers')->group(function ($router) {
    $router->post('/exports', 'exports')->name('developers.exports');
    $router->get('/trash', 'trash')->name('developer.trash');
    $router->post('/{developer}/restore', 'restore')->name('developer.restore');
});
$router->apiResource('/developers', DeveloperController::class);

/**
 * Static Resource
 */
$router->get('/resources/statics', [ResourceController::class, 'staticResource']);
$router->get('/resources/dynamics', [ResourceController::class, 'dynamicResources']);

/**
 * Client Module
 */
$router->controller(ClientController::class)->prefix('/clients')->group(function ($router) {
    $router->get('/trash', 'trash')->name('client.trash');
    $router->post('/{client}/restore', 'restore')->name('client.restore');
});
$router->apiResource('/clients', ClientController::class);
$router->post('/clients/{client}/restore', [ClientController::class, 'restore'])->name('clients.restore');

$router->apiResource('/client-requirements', ClientRequirementController::class);
$router->controller(ClientRequirementController::class)->group(function ($router) {
    $router->post('/client-requirements/{requirement}/complete', 'complete')->name('client-requirements.complete');
    $router->post('/client-requirements/{requirement}/cancel', 'cancel')->name('client-requirements.cancel');
    $router->post('/client-requirements/{client_requirement}/restore', 'restore')->name('client-requirements.restore');
});

$router->apiResource('/client-payments', ClientPaymentController::class);

/**
 * Payment Documents
 */
$router->controller(ClientPaymentController::class)->group(function ($router) {
    $router->post('/client-payments/{id}/upload-documents', 'uploadDocuments');
    $router->get('/payments/{payment}/documents/{document}', 'downloadDocument');
    $router->delete('/client-payments/{payment}/documents/{document}', 'deleteDocument');
});

/**
 * Settings
 */
$router->get('/settings', [SettingController::class, 'index']);
$router->get('/settings/theme', [SettingController::class, 'getTheme']);
$router->put('/settings/theme', [SettingController::class, 'updateTheme']);

/**
 * Uploads
 */
$router->post('/uploads/image', [FileUploadController::class, 'uploadImage']);
$router->post('/uploads/images', [FileUploadController::class, 'uploadMultiImages']);
$router->post('/uploads/document', [FileUploadController::class, 'uploadDocument']);
$router->post('/uploads/documents', [FileUploadController::class, 'uploadMultiDocuments']);

/**
 * Contacts
 */
$router->get('/contacts', [ContactController::class, 'index']);

/**
 * Facility Module
 */
$router->controller(FacilityController::class)->prefix('/facilities')->group(function ($router) {
    $router->post('/exports', 'exports')->name('facilities.exports');
    $router->get('/trash', 'trash')->name('facility.trash');
    $router->post('/{facility}/restore', 'restore')->name('facility.restore');
});
$router->apiResource('/facilities', FacilityController::class);

/**
 * Site Inquiry
 */
$router->apiResource('/site-inquiries', SiteInquiryController::class);
$router->post('/site-inquiries', [SiteInquiryController::class, 'store']);
$router->get('/site-inquiries', [SiteInquiryController::class, 'index']);

/**
 * Site Inquiry
 */
$router->get('/dashboard', [DashboardController::class, 'index']);

/**
 * Contact Company
 */
$router->apiResource('/contact-companies', ContactCompanyController::class);
$router->post('/contact-companies', [ContactCompanyController::class, 'store']);

$router->apiResource('/cards', CardController::class);
// $router->post('/cards', [CardController::class, 'store']);