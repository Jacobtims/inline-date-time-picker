<?php

namespace Jacobtims\InlineDateTimePicker;

use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Jacobtims\InlineDateTimePicker\Testing\TestsInlineDateTimePicker;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class InlineDateTimePickerServiceProvider extends PackageServiceProvider
{
    public static string $name = 'inline-date-time-picker';

    public static string $viewNamespace = 'inline-date-time-picker';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews(static::$viewNamespace);
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Testing
        Testable::mixin(new TestsInlineDateTimePicker);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'jacobtims/inline-date-time-picker';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('inline-date-time-picker', __DIR__ . '/../resources/dist/components/inline-date-time-picker.js'),
            Css::make('inline-date-time-picker-styles', __DIR__ . '/../resources/dist/inline-date-time-picker.css'),
            Js::make('inline-date-time-picker-scripts', __DIR__ . '/../resources/dist/inline-date-time-picker.js'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }
}
