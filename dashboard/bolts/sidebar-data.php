<?php

$dealership_company_mapped = [];
$dealership_list           = $user['accounts'];
$dealership_CSV            = implode("','", $dealership_list);
$dealership_CSV            = "'" . $dealership_CSV . "'";
$companyQuery              = "SELECT dealership, company_name FROM dealerships WHERE dealership IN ($dealership_CSV) ORDER BY company_name ASC";
$companyQueryResult = DbConnect::get_instance()->query($companyQuery);
$db_dealershiplist  = [];

while ($companyFetch = mysqli_fetch_assoc($companyQueryResult)) {
    $company = trim($companyFetch['company_name']);

    if ($company == '') {
        $company = $companyFetch['dealership'];
    }

    $dealership_company_mapped[$companyFetch['dealership']] = ucfirst($company);
    $db_dealershiplist[]                                    = $companyFetch['dealership'];
}

$dealerships_diff = array_diff($dealership_list, $db_dealershiplist);

foreach ($dealerships_diff as $key => $value) {
    $dealership_company_mapped[$value] = ucfirst($value);
}

natcasesort($dealership_company_mapped);
