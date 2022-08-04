<?php

namespace App\Modules\Permission\Enum;

enum Permission: string
{
    case PUBLISH_TEAM_LISTING = 'publish_team_property';
    case PUBLISH_BRANCH_LISTING = 'publish_branch_property';
    case PUBLISH_COMPANY_LISTING = 'publish_company_property';
    case PUBLISH_ANY_LISTING = 'publish_any_property';

    case VIEW_COMPANY_DASHBOARD = 'view_company_dashboard';
    case VIEW_BRANCH_DASHBOARD = 'view_branch_dashboard';
    case VIEW_TEAM_DASHBOARD = 'view_team_dashboard';

    /** Client Type module permissions */
    case VIEW_CLIENT_TYPE = 'view_client_type';
    case CREATE_CLIENT_TYPE = 'create_client_type';
    case UPDATE_CLIENT_TYPE = 'update_client_type';
    case DELETE_CLIENT_TYPE = 'delete_client_type';

    /** Development Type module permissions */
    case VIEW_DEVELOPMENT_TYPE = 'view_development_type';
    case CREATE_DEVELOPMENT_TYPE = 'create_development_type';
    case UPDATE_DEVELOPMENT_TYPE = 'update_development_type';
    case DELETE_DEVELOPMENT_TYPE = 'delete_development_type';

    /** Property Type module permissions */
    case VIEW_PROPERTY_TYPE = 'view_property_type';
    case CREATE_PROPERTY_TYPE = 'create_property_type';
    case UPDATE_PROPERTY_TYPE = 'update_property_type';
    case DELETE_PROPERTY_TYPE = 'delete_property_type';

    /** User module permissions */
    case VIEW_TEAM_USER = 'view_team_user';
    case VIEW_BRANCH_USER = 'view_branch_user';
    case VIEW_COMPANY_USER = 'view_company_user';
    case VIEW_ANY_USER = 'view_any_user';
    case CREATE_TEAM_USER = 'create_team_user';
    case CREATE_BRANCH_USER = 'create_branch_user';
    case CREATE_COMPANY_USER = 'create_company_user';
    case CREATE_ANY_USER = 'create_any_user';
    case UPDATE_TEAM_USER = 'update_team_user';
    case UPDATE_BRANCH_USER = 'update_branch_user';
    case UPDATE_COMPANY_USER = 'update_company_user';
    case UPDATE_ANY_USER = 'update_any_user';
    case DELETE_TEAM_USER = 'delete_team_user';
    case DELETE_BRANCH_USER = 'delete_branch_user';
    case DELETE_COMPANY_USER = 'delete_company_user';
    case DELETE_ANY_USER = 'delete_any_user';

    /** Role module permissions */
    case VIEW_ROLE = 'view_role';
    case CREATE_ROLE = 'create_role';
    case UPDATE_ROLE = 'update_role';
    case DELETE_ROLE = 'delete_role';

    /** Team module permissions */
    case VIEW_BRANCH_TEAM = 'view_branch_team';
    case VIEW_COMPANY_TEAM = 'view_company_team';
    case VIEW_ANY_TEAM = 'view_any_team';
    case CREATE_BRANCH_TEAM = 'create_branch_team';
    case CREATE_COMPANY_TEAM = 'create_company_team';
    case CREATE_ANY_TEAM = 'create_any_team';
    case UPDATE_BRANCH_TEAM = 'update_branch_team';
    case UPDATE_COMPANY_TEAM = 'update_company_team';
    case UPDATE_ANY_TEAM = 'update_any_team';
    case DELETE_BRANCH_TEAM = 'delete_branch_team';
    case DELETE_COMPANY_TEAM = 'delete_company_team';
    case DELETE_ANY_TEAM = 'delete_any_team';

    /** Location modules permissions (country, province, district, commune) */
    case VIEW_LOCATION = 'view_location';
    case CREATE_LOCATION = 'create_location';
    case UPDATE_LOCATION = 'update_location';
    case DELETE_LOCATION = 'delete_location';

    /** General setting module permissions */
    case VIEW_GENERAL_SETTING = 'view_general_setting';
    case UPDATE_GENERAL_SETTING = 'update_general_setting';

    /** Property module permissions */
    case VIEW_PROPERTY = 'view_property';
    case VIEW_ANY_PROPERTY = 'view_any_property';
    case CREATE_PROPERTY = 'create_property';
    case CREATE_TEAM_PROPERTY = 'create_team_property';
    case CREATE_BRANCH_PROPERTY = 'create_branch_property';
    case CREATE_COMPANY_PROPERTY = 'create_company_property';
    case CREATE_ANY_PROPERTY = 'create_any_property';
    case UPDATE_PROPERTY = 'update_property';
    case UPDATE_TEAM_PROPERTY = 'update_team_property';
    case UPDATE_BRANCH_PROPERTY = 'update_branch_property';
    case UPDATE_COMPANY_PROPERTY = 'update_company_property';
    case UPDATE_ANY_PROPERTY = 'update_any_property';
    case DELETE_PROPERTY = 'delete_property';
    case DELETE_TEAM_PROPERTY = 'delete_team_property';
    case DELETE_BRANCH_PROPERTY = 'delete_branch_property';
    case DELETE_COMPANY_PROPERTY = 'delete_company_property';
    case DELETE_ANY_PROPERTY = 'delete_any_property';
    case APPROVE_TEAM_LISTING = 'approve_team_property';
    case APPROVE_BRANCH_LISTING = 'approve_branch_property';
    case APPROVE_COMPANY_LISTING = 'approve_company_property';
    case APPROVE_ANY_LISTING = 'approve_any_property';

    /** Property Sale Contacts */
    case VIEW_TEAM_PROPERTY_SALE_CONTACT = 'view_team_property_sale_contact';
    case VIEW_BRANCH_PROPERTY_SALE_CONTACT = 'view_branch_property_sale_contact';
    case VIEW_COMPANY_PROPERTY_SALE_CONTACT = 'view_company_property_sale_contact';
    case VIEW_ANY_PROPERTY_SALE_CONTACT = 'view_any_property_sale_contact';

    /** Property Owner Contacts */
    case VIEW_TEAM_PROPERTY_OWNER_CONTACT = 'view_team_property_owner_contact';
    case VIEW_BRANCH_PROPERTY_OWNER_CONTACT = 'view_branch_property_owner_contact';
    case VIEW_COMPANY_PROPERTY_OWNER_CONTACT = 'view_company_property_owner_contact';
    case VIEW_ANY_PROPERTY_OWNER_CONTACT = 'view_any_property_owner_contact';

    /** Property Document */
    case VIEW_ANY_PROPERTY_DOCUMENT = 'view_any_property_document';
    case VIEW_BRANCH_PROPERTY_DOCUMENT = 'view_branch_property_document';
    case VIEW_COMPANY_PROPERTY_DOCUMENT = 'view_company_property_document';
    case VIEW_TEAM_PROPERTY_DOCUMENT = 'view_team_property_document';

    /** Exclusive module permissions */
    case VIEW_EXCLUSIVE = 'view_exclusive';
    case VIEW_TEAM_EXCLUSIVE = 'view_team_exclusive';
    case VIEW_BRANCH_EXCLUSIVE = 'view_branch_exclusive';
    case VIEW_COMPANY_EXCLUSIVE = 'view_company_exclusive';
    case VIEW_ANY_EXCLUSIVE = 'view_any_exclusive';
    case SET_EXCLUSIVE_AVAILABILITY = 'set_exclusive_availability';
    case ADD_EXCLUSIVE_STORY = 'add_exclusive_story';

    /** Project module permissions */
    case VIEW_PROJECT = 'view_project';
    case CREATE_PROJECT = 'create_project';
    case UPDATE_PROJECT = 'update_project';
    case DELETE_PROJECT = 'delete_project';

    /** Developer module permissions */
    case VIEW_DEVELOPER = 'view_developer';
    case CREATE_DEVELOPER = 'create_developer';
    case UPDATE_DEVELOPER = 'update_developer';
    case DELETE_DEVELOPER = 'delete_developer';

    /** Client module permissions */
    case VIEW_CLIENT = 'view_client';
    case VIEW_TEAM_CLIENT = 'view_team_client';
    case VIEW_BRANCH_CLIENT = 'view_branch_client';
    case VIEW_COMPANY_CLIENT = 'view_company_client';
    case VIEW_ANY_CLIENT = 'view_any_client';
    case CREATE_CLIENT = 'create_client';
    case CREATE_TEAM_CLIENT = 'create_team_client';
    case CREATE_BRANCH_CLIENT = 'create_branch_client';
    case CREATE_COMPANY_CLIENT = 'create_company_client';
    case CREATE_ANY_CLIENT = 'create_any_client';
    case UPDATE_CLIENT = 'update_client';
    case UPDATE_TEAM_CLIENT = 'update_team_client';
    case UPDATE_BRANCH_CLIENT = 'update_branch_client';
    case UPDATE_COMPANY_CLIENT = 'update_company_client';
    case UPDATE_ANY_CLIENT = 'update_any_client';
    case DELETE_CLIENT = 'delete_client';
    case DELETE_TEAM_CLIENT = 'delete_team_client';
    case DELETE_BRANCH_CLIENT = 'delete_branch_client';
    case DELETE_COMPANY_CLIENT = 'delete_company_client';
    case DELETE_ANY_CLIENT = 'delete_any_client';

    /** Company Info module permissions */
    case VIEW_ANY_COMPANY = 'view_any_company';
    case CREATE_ANY_COMPANY = 'create_any_company';
    case UPDATE_ANY_COMPANY = 'update_any_company';
    case DELETE_ANY_COMPANY = 'delete_any_company';

    /** Company Branch module permissions */
    case VIEW_COMPANY_BRANCH = 'view_company_branch';
    case VIEW_ANY_COMPANY_BRANCH = 'view_any_company_branch';
    case CREATE_COMPANY_BRANCH = 'create_company_branch';
    case CREATE_ANY_COMPANY_BRANCH = 'create_any_company_branch';
    case UPDATE_COMPANY_BRANCH = 'update_company_branch';
    case UPDATE_ANY_COMPANY_BRANCH = 'update_any_company_branch';
    case DELETE_COMPANY_BRANCH = 'delete_company_branch';
    case DELETE_ANY_COMPANY_BRANCH = 'delete_any_company_branch';

    /** Proposal module permissions */
    case VIEW_PROPOSAL = 'view_proposal';
    case VIEW_TEAM_PROPOSAL = 'view_team_proposal';
    case VIEW_BRANCH_PROPOSAL = 'view_branch_proposal';
    case VIEW_COMPANY_PROPOSAL = 'view_company_proposal';
    case VIEW_ANY_PROPOSAL = 'view_any_proposal';
    case CREATE_PROPOSAL = 'create_proposal';
    case CREATE_TEAM_PROPOSAL = 'create_team_proposal';
    case CREATE_BRANCH_PROPOSAL = 'create_branch_proposal';
    case CREATE_COMPANY_PROPOSAL = 'create_company_proposal';
    case CREATE_ANY_PROPOSAL = 'create_any_proposal';
    case UPDATE_PROPOSAL = 'update_proposal';
    case UPDATE_TEAM_PROPOSAL = 'update_team_proposal';
    case UPDATE_BRANCH_PROPOSAL = 'update_branch_proposal';
    case UPDATE_COMPANY_PROPOSAL = 'update_company_proposal';
    case UPDATE_ANY_PROPOSAL = 'update_any_proposal';
    case DELETE_PROPOSAL = 'delete_proposal';
    case DELETE_TEAM_PROPOSAL = 'delete_team_proposal';
    case DELETE_BRANCH_PROPOSAL = 'delete_branch_proposal';
    case DELETE_COMPANY_PROPOSAL = 'delete_company_proposal';
    case DELETE_ANY_PROPOSAL = 'delete_any_proposal';

    /** Loan module permissions */
    case VIEW_LOAN_APPLICATION = 'view_loan_application';
    case VIEW_ANY_LOAN_APPLICATION = 'view_any_loan_application';
    case CREATE_LOAN_APPLICATION = 'create_loan_application';
    case UPDATE_LOAN_APPLICATION = 'update_loan_application';
    case UPDATE_ANY_LOAN_APPLICATION = 'update_any_loan_application';
    case DELETE_LOAN_APPLICATION = 'delete_loan_application';
    case DELETE_ANY_LOAN_APPLICATION = 'delete_any_loan_application';
    case APPROVE_LOAN_APPLICATION = 'approve_loan_application';
    case COMMENT_ON_LOAN_APPLICATION = 'comment_on_loan_application';
    case ANALYSE_LOAN_APPLICATION = 'analyse_loan';
    case PRINT_LOAD_PAYMENT_SCHEDULE = 'print_loan_payment_schedule';

    /** Loan rate module permissions */
    case VIEW_LOAN_RATE = 'view_loan_rate';
    case UPDATE_LOAN_RATE = 'update_loan_rate';

    /** Loan cashflow module permissions */
    case VIEW_CASH_FLOW = 'view_loan_cash_flow';
    case PRINT_CASH_FLOW = 'print_loan_cash_flow';

    /** Bank  module permissions */
    case VIEW_BANK = 'view_bank';
    case CREATE_BANK = 'create_bank';
    case UPDATE_BANK = 'update_bank';
    case DELETE_BANK = 'delete_bank';

    /** Bank Branch module permissions */
    case VIEW_BANK_BRANCH = 'view_bank_branch';
    case CREATE_BANK_BRANCH = 'create_bank_branch';
    case UPDATE_BANK_BRANCH = 'update_bank_branch';
    case DELETE_BANK_BRANCH = 'delete_bank_branch';

    /** Audit report module permissions */
    case VIEW_AUDIT_REPORT = 'view_audit_report';
    case DOWNLOAD_AUDIT_REPORT = 'download_audit_report';

    /** Valuation report module permissions */
    case VIEW_VALUATION_REPORT = 'view_valuation_report';
    case CREATE_VALUATION_REPORT = 'create_valuation_report';
    case UPDATE_VALUATION_REPORT = 'update_valuation_report';
    case DELETE_VALUATION_REPORT = 'delete_valuation_report';

    /** Audit report module permissions */
    case VIEW_EVALUATED_REPORT = 'view_evaluated_report';
    case DOWNLOAD_EVALUATED_REPORT = 'download_evaluated_report';

    /** Facility module permissions */
    case VIEW_FACILITY = 'view_facility';
    case CREATE_FACILITY = 'create_facility';
    case UPDATE_FACILITY = 'update_facility';
    case DELETE_FACILITY = 'delete_facility';

    /** Transfer module permission */
    case TRANSFER_TEAM_PROPERTY = 'transfer_team_property';
    case TRANSFER_BRANCH_PROPERTY = 'transfer_branch_property';
    case TRANSFER_COMPANY_PROPERTY = 'transfer_company_property';
}
