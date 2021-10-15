<?php


namespace App\Http\Traits;


class StatusHelperClass
{
    //--- Campaign Cycle Statuses
    const CYCLE_MID = 1;
    const CYCLE_END = 2;
    const CYCLE_OTO = 3;

    protected static $campaignsCycles = [
        self::CYCLE_MID => 'MID',
        self::CYCLE_END => 'END',
        self::CYCLE_OTO => 'OTO'
    ];

    public static function getCampaignsCycles()
    {
        return self::$campaignsCycles;
    }

    //--- Campaign Statuses
    const CAMPAIGN_ACTIVE = 1;
    const CAMPAIGN_SUSPENDED = 2;
    const CAMPAIGN_INACTIVE = 3;

    protected static $campaignsStatuses = [
        self::CAMPAIGN_ACTIVE => 'ACTIVE',
        self::CAMPAIGN_SUSPENDED => 'SUSPENDED',
        self::CAMPAIGN_INACTIVE => 'INACTIVE'
    ];

    public static function getCampaignsStatuses()
    {
        return self::$campaignsStatuses;
    }

    public static function campaign_status()
    {
        return [
            '1' => 'ACTIVE',
            '2' => 'SUSPENDED',
            '3' => 'INACTIVE'
        ];
    }

    //--- Package Elements Statuses
    const PACKAGE_ELEMENT_STATUS_ACTIVE = 1;
    const PACKAGE_ELEMENT_STATUS_INACTIVE = 2;

    protected  static $packageElementsStatuses = [
        self::PACKAGE_ELEMENT_STATUS_ACTIVE => 'Active',
        self::PACKAGE_ELEMENT_STATUS_INACTIVE => 'Inactive',
    ];

    public static function getPackageElementStatus(){
        return self::$packageElementsStatuses;
    }

    const PACKAGE_ELEMENT_FIRST_MONTH = 1;
    const PACKAGE_ELEMENT_SECOND_MONTH = 0;

    //--- Package Status
    const PACKAGE_STATUS_ACTIVE = 1;
    const PACKAGE_STATUS_INACTIVE = 2;


    protected  static $packageStatuses = [
        self::PACKAGE_STATUS_ACTIVE => 'Active',
        self::PACKAGE_STATUS_INACTIVE => 'Inactive',
    ];

    public static function getPackageStatus(){
        return self::$packageStatuses;
    }

    //--- Package Field Type
    const PACKAGE_FIELD_NUMBER = 1;
    const PACKAGE_FIELD_BIANRY = 2;

    protected static $packageFieldType = [
        self::PACKAGE_FIELD_NUMBER => 'Number',
        self::PACKAGE_FIELD_BIANRY => 'Binary'
    ];

    public static function getPackageFieldTypes(){
        return self::$packageElementsStatuses;
    }

    //--- Package Frequency
    const PACKAGE_FREQUENCY_EVERY_MONTH = 1;
    const PACKAGE_FREQUENCY_EVERY_TWO_MONTH = 2;
    const PACKAGE_FREQUENCY_EVERY_THREE_MONTH = 3;
    const PACKAGE_FREQUENCY_EVERY_SIX_MONTH = 4;

    protected static $packageFrequency = [
        self::PACKAGE_FREQUENCY_EVERY_MONTH => 'Every Month',
        self::PACKAGE_FREQUENCY_EVERY_TWO_MONTH => 'Every 2 Months',
        self::PACKAGE_FREQUENCY_EVERY_THREE_MONTH => 'Every 3 Months',
        self::PACKAGE_FREQUENCY_EVERY_SIX_MONTH => 'Every 6 Months',
    ];

    public static function getPackageFrequency(){
        return self::$packageFrequency;
    }

    //---package frequency code for API
    protected static $packageFrequencyCode = [
        self::PACKAGE_FREQUENCY_EVERY_MONTH => 'monthly',
        self::PACKAGE_FREQUENCY_EVERY_TWO_MONTH => 'every2months',
        self::PACKAGE_FREQUENCY_EVERY_THREE_MONTH => 'every3months',
        self::PACKAGE_FREQUENCY_EVERY_SIX_MONTH => 'every6months',
    ];

    public static function getpackageFrequencyCode(){
        return self::$packageFrequencyCode;
    }
}
