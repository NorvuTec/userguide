<?php

namespace Norvutec\UserGuideBundle\Component;

use Norvutec\UserGuideBundle\Component\Builder\RouteCheckUserGuideBuilder;
use Norvutec\UserGuideBundle\Component\Builder\UserGuideBuilder;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Abstract class for UserGuide definition
 * Will be tagged by services with norvutec.user_guide.guide
 */
#[AutoconfigureTag('norvutec.user_guide.guide')]
abstract class UserGuide {

    /**
     * Returns the unique id of the user guide
     * @return string unique id of the user guide
     */
    public function id(): string {
        return self::guideId();
    }

    /**
     * Returns the name of the user guide
     * The name will be translated via translator
     * @return string name of the user guide
     */
    abstract public function name(): string;

    /**
     * Checks if the user guide can be started
     * For example check for permissions or other requirements
     * @default true
     * @return bool true if the user guide can be started
     */
    public function canStart(): bool {
        return true;
    }

    /**
     * Configures the user guide via the user guide builder
     * @param UserGuideBuilder $builder builder to configure the user guide
     * @return void
     */
    abstract public function configure(UserGuideBuilder $builder): void;

    /**
     * Returns the unique id of the user guide
     * @return string unique id of the user guide
     */
    public static function guideId(): string {
        return md5(static::class);
    }

}