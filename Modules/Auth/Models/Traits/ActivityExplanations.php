<?php

namespace Modules\Auth\Models\Traits;

trait ActivityExplanations
{
    //-------------------------------------------
    // require RequestLocalization trait
    //-------------------------------------------

    /** @var array */
    protected static $activitiesEx = [
        '41' => 'auth::activity.login',
        '42' => 'auth::activity.logout',
        '43' => 'auth::activity.register',

        '11' => 'auth::profile.full_name_updated',
        '12' => 'auth::profile.birthday_updated',
        '13' => 'auth::profile.gender_updated',
        '14' => 'auth::profile.username_updated',
        '15' => 'auth::profile.avatar_updated',

        '31' => 'auth::post.created',
        '32' => 'auth::post.updated',
        '33' => 'auth::post.published',
        '34' => 'auth::post.deleted',
        '35' => 'auth::post.publisher',
        '36' => 'auth::post.publication_notify',
        '37' => 'auth::post.waited',
        '38' => 'auth::post.waited_notify',

        '510' => 'auth::admin.user_disabled',
        '511' => 'auth::admin.user_enabled',
    ];

    /** @var array */
    protected static $label = [
        '1' => 'Biodata',
        '2' => 'Identity',
        '3' => 'Post',
        '4' => 'Activity',
        '5' => 'Admin',

        '41' => 'auth::activity.login_label',
        '42' => 'auth::activity.logout_label',
        '43' => 'auth::activity.register_label',

        '11' => 'auth::profile.full_name_updated_label',
        '12' => 'auth::profile.birthday_updated_label',
        '13' => 'auth::profile.gender_updated_label',
        '14' => 'auth::profile.username_updated_label',
        '15' => 'auth::profile.avatar_updated_label',

        '31' => 'auth::post.created_label',
        '32' => 'auth::post.updated_label',
        '33' => 'auth::post.published_label',
        '34' => 'auth::post.deleted_label',
        '35' => 'auth::post.publisher_label',
        '36' => 'auth::post.publication_notify_label',
        '37' => 'auth::post.waited_label',
        '38' => 'auth::post.waited_notify_label',

        '510' => 'auth::admin.user_disabled_label',
        '511' => 'auth::admin.user_enabled_label',
    ];

    public static function showAllCodes(): array
    {
        $codes = [];
        foreach (self::$activitiesEx as $id => $activity) {
            $codes[] = [
                'id' => $id,
                'label' => '#'. $id .' ('. __($activity.'_label'). ')',
            ];
        }
        return $codes;
    }

    protected function showExplanation(int $code): ?string
    {
        if (! array_key_exists($code, self::$activitiesEx)) {
            return null;
        }

        return $this->translate(self::$activitiesEx[$code], $this->getLocale(request()));
    }

    protected function showLabel(int $code): ?string
    {
        if (! array_key_exists($code, self::$label)) {
            return null;
        }

        return $this->translate(self::$label[$code], $this->getLocale(request()));
    }

}
