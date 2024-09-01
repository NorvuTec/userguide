<?php

namespace Norvutec\UserGuideBundle\Component;

use Symfony\Component\HttpFoundation\Session\SessionBagInterface;

/**
 * Session bag for user guide
 */
class UserGuideBag implements SessionBagInterface {

    public const BAG_NAME = "user_guide";
    private const KEY_CURRENT_GUIDE = "current_guide";
    private const KEY_CURRENT_STEP = "current_step";

    private array $data = [];

    public function __construct() {

    }

    public function getName(): string {
        return self::BAG_NAME;
    }

    public function initialize(array &$array): void {
        $this->data = $array;
    }

    public function getStorageKey(): string {
        return "norvutec_".self::BAG_NAME;
    }

    public function clear(): mixed {
        return null;
    }

    public function getCurrentGuide(): ?string {
        return $this->data[self::KEY_CURRENT_GUIDE] ?? null;
    }

    public function setCurrentGuide(string $guide): void {
        $this->data[self::KEY_CURRENT_GUIDE] = $guide;
    }

    public function getCurrentStep(): ?int {
        return $this->data[self::KEY_CURRENT_STEP] ?? null;
    }

    public function setCurrentStep(int $step): void {
        $this->data[self::KEY_CURRENT_STEP] = $step;
    }
}