<?php
namespace App\Http\Controllers\SystemManagement;
use App\Filters\GenericFilter;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\SystemManagement\Traits\CountryCityState;
use App\Http\Controllers\SystemManagement\Traits\LegalEntities;
use App\Http\Controllers\SystemManagement\Traits\ModulesTrait;
use App\Http\Controllers\SystemManagement\Traits\PaymentTerm;
use App\Http\Controllers\SystemManagement\Traits\RegistrationTypeTrait;
use App\Http\Controllers\SystemManagement\Traits\SidenavTrait;
use App\Http\Controllers\SystemManagement\Traits\ContactType;
use App\Http\Controllers\SystemManagement\Traits\Timezone;
use App\Http\Controllers\SystemManagement\Traits\Units;
use Illuminate\Http\Request;


class SetupController extends Controller
{
    use SidenavTrait , ContactType , Timezone , ModulesTrait , CountryCityState , RegistrationTypeTrait , LegalEntities,
        PaymentTerm , Units;
    public $request , $filter;
    public function __construct(Request $request , GenericFilter $filter)
    {
        $this->middleware(["auth"]);
        $this->request = $request;
        $this->filter = $filter;
    }
    public function dashboard()
    {
        $nav = $this->loadNavs();
        echo view("Support.flex")->with("navs" , $nav);
    }
    public function mainContent()
    {
        echo view("Dashboard.dashboard");
    }
    public function loadContactTypes()
    {
        echo view("Dashboard.OrganizationAdministration.Contact-Types.contact_types");
    }
    public function newContactType()
    {
        echo view("Dashboard.OrganizationAdministration.Contact-Types.form_contact_types");
    }
    public function modulesGrid()
    {
        echo view("Dashboard.ERPAdministration.Modules.modules-grid");
    }
    public function modulesForm()
    {
        echo view("Dashboard.ERPAdministration.Modules.modules-form");
    }
    public function CountryCityState()
    {
        echo view("Dashboard.OrganizationAdministration.CountryCityState.grid");
    }
    public function FormCountryCityState()
    {
        echo view("Dashboard.OrganizationAdministration.CountryCityState.form");
    }
    public function showRegistrationTypesGrid()
    {
        echo view("Dashboard.OrganizationAdministration.RegistrationTypes.grid");
    }
    public function showRegistrationTypesForm()
    {
        echo view("Dashboard.OrganizationAdministration.RegistrationTypes.form");
    }
    public function showLegalEntitiesForm()
    {
        echo view("Dashboard.OrganizationAdministration.LegalEntities.form");
    }

    public function paymentTerms()
    {
        echo view("Dashboard.ERPAdministration.Payment Terms.payment-term");
    }

    public function showUnitClass()
    {
        echo view("Dashboard.OrganizationAdministration.Units.unit-class");
    }

    public function showUnit()
    {
        echo view("Dashboard.OrganizationAdministration.Units.unit");
    }


}
