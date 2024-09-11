<?php

namespace Jacobtims\InlineDateTimePicker\Forms\Components;

use Carbon\CarbonInterface;
use Carbon\Exceptions\InvalidFormatException;
use Closure;
use DateTime;
use Filament\Forms\Components\Concerns;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasExtraAlpineAttributes;
use Illuminate\Support\Carbon;
use Illuminate\View\ComponentAttributeBag;

class InlineDateTimePicker extends Field
{
    use Concerns\CanBeReadOnly;
    use Concerns\HasExtraInputAttributes;
    use Concerns\HasStep;
    use HasExtraAlpineAttributes;

    /**
     * @var \Filament\Forms\Components\view-string
     */
    protected string $view = 'inline-date-time-picker::forms.components.inline-date-time-picker';

    /**
     * @var \Closure
     */
    protected array $extraTriggerAttributes = [];

    protected ?int $firstDayOfWeek = null;

    protected string | Closure | null $format = null;

    protected bool | Closure $hasDate = true;

    protected bool | Closure $hasSeconds = true;

    protected bool | Closure $hasTime = true;

    protected CarbonInterface | string | Closure | null $maxDate = null;

    protected CarbonInterface | string | Closure | null $minDate = null;

    protected string | Closure | null $timezone = null;

    protected string | Closure | null $locale = null;

    /**
     * @var array<DateTime | string> | Closure
     */
    protected array | Closure $disabledDates = [];

    protected int | Closure | null $hoursStep = null;

    protected int | Closure | null $minutesStep = null;

    protected int | Closure | null $secondsStep = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(static function (InlineDateTimePicker $component, $state): void {
            if (blank($state)) {
                return;
            }

            if (! $state instanceof CarbonInterface) {
                try {
                    $state = Carbon::createFromFormat($component->getFormat(), (string) $state, config('app.timezone'));
                } catch (InvalidFormatException $exception) {
                    try {
                        $state = Carbon::parse($state, config('app.timezone'));
                    } catch (InvalidFormatException $exception) {
                        $component->state(null);

                        return;
                    }
                }
            }

            $state = $state->setTimezone($component->getTimezone());

            $component->state((string) $state);
        });

        $this->dehydrateStateUsing(static function (InlineDateTimePicker $component, $state) {
            if (blank($state)) {
                return null;
            }

            if (! $state instanceof CarbonInterface) {
                $state = Carbon::parse($state);
            }

            $state->shiftTimezone($component->getTimezone());
            $state->setTimezone(config('app.timezone'));

            return $state->format($component->getFormat());
        });

        $this->rule(
            'date',
            static fn (InlineDateTimePicker $component): bool => $component->hasDate(),
        );
    }

    /**
     * @param  array<mixed> | Closure  $attributes
     */
    public function extraTriggerAttributes(array | Closure $attributes, bool $merge = false): static
    {
        if ($merge) {
            $this->extraAttributes[] = $attributes;
        } else {
            $this->extraAttributes = [$attributes];
        }

        return $this;
    }

    public function firstDayOfWeek(?int $day): static
    {
        if ($day < 0 || $day > 7) {
            $day = null;
        }

        $this->firstDayOfWeek = $day;

        return $this;
    }

    public function format(string | Closure | null $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function maxDate(CarbonInterface | string | Closure | null $date): static
    {
        $this->maxDate = $date;

        $this->rule(static function (InlineDateTimePicker $component) {
            return "before_or_equal:{$component->getMaxDate()}";
        }, static fn (InlineDateTimePicker $component): bool => (bool) $component->getMaxDate());

        return $this;
    }

    public function minDate(CarbonInterface | string | Closure | null $date): static
    {
        $this->minDate = $date;

        $this->rule(static function (InlineDateTimePicker $component) {
            return "after_or_equal:{$component->getMinDate()}";
        }, static fn (InlineDateTimePicker $component): bool => (bool) $component->getMinDate());

        return $this;
    }

    /**
     * @param  array<DateTime | string> | Closure  $dates
     */
    public function disabledDates(array | Closure $dates): static
    {
        $this->disabledDates = $dates;

        return $this;
    }

    public function resetFirstDayOfWeek(): static
    {
        $this->firstDayOfWeek(null);

        return $this;
    }

    public function hoursStep(int | Closure | null $hoursStep): static
    {
        $this->hoursStep = $hoursStep;

        return $this;
    }

    public function minutesStep(int | Closure | null $minutesStep): static
    {
        $this->minutesStep = $minutesStep;

        return $this;
    }

    public function secondsStep(int | Closure | null $secondsStep): static
    {
        $this->secondsStep = $secondsStep;

        return $this;
    }

    public function timezone(string | Closure | null $timezone): static
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function locale(string | Closure | null $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function weekStartsOnMonday(): static
    {
        $this->firstDayOfWeek(1);

        return $this;
    }

    public function weekStartsOnSunday(): static
    {
        $this->firstDayOfWeek(7);

        return $this;
    }

    public function date(bool | Closure $condition = true): static
    {
        $this->hasDate = $condition;

        return $this;
    }

    public function seconds(bool | Closure $condition = true): static
    {
        $this->hasSeconds = $condition;

        return $this;
    }

    public function time(bool | Closure $condition = true): static
    {
        $this->hasTime = $condition;

        return $this;
    }

    /**
     * @deprecated Use `date()` instead.
     */
    public function withoutDate(bool | Closure $condition = true): static
    {
        $this->date(fn (InlineDateTimePicker $component): bool => ! $component->evaluate($condition));

        return $this;
    }

    /**
     * @deprecated Use `seconds()` instead.
     */
    public function withoutSeconds(bool | Closure $condition = true): static
    {
        $this->seconds(fn (InlineDateTimePicker $component): bool => ! $component->evaluate($condition));

        return $this;
    }

    /**
     * @deprecated Use `time()` instead.
     */
    public function withoutTime(bool | Closure $condition = true): static
    {
        $this->time(fn (InlineDateTimePicker $component): bool => ! $component->evaluate($condition));

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function getExtraTriggerAttributes(): array
    {
        $temporaryAttributeBag = new ComponentAttributeBag;

        foreach ($this->extraTriggerAttributes as $extraTriggerAttributes) {
            $temporaryAttributeBag = $temporaryAttributeBag->merge($this->evaluate($extraTriggerAttributes));
        }

        return $temporaryAttributeBag->getAttributes();
    }

    public function getExtraTriggerAttributeBag(): ComponentAttributeBag
    {
        return new ComponentAttributeBag($this->getExtraTriggerAttributes());
    }

    public function getFirstDayOfWeek(): int
    {
        return $this->firstDayOfWeek ?? 1;
    }

    public function getFormat(): string
    {
        $format = $this->evaluate($this->format);

        if ($format) {
            return $format;
        }

        $format = $this->hasDate() ? 'Y-m-d' : '';

        if (! $this->hasTime()) {
            return $format;
        }

        $format = $format ? "{$format} H:i" : 'H:i';

        if (! $this->hasSeconds()) {
            return $format;
        }

        return "{$format}:s";
    }

    public function getMaxDate(): ?string
    {
        return $this->evaluate($this->maxDate);
    }

    public function getMinDate(): ?string
    {
        return $this->evaluate($this->minDate);
    }

    /**
     * @return array<DateTime | string>
     */
    public function getDisabledDates(): array
    {
        return $this->evaluate($this->disabledDates);
    }

    public function getTimezone(): string
    {
        return $this->evaluate($this->timezone) ?? config('app.timezone');
    }

    public function getLocale(): string
    {
        return $this->evaluate($this->locale) ?? config('app.locale');
    }

    public function hasDate(): bool
    {
        return (bool) $this->evaluate($this->hasDate);
    }

    public function hasSeconds(): bool
    {
        return (bool) $this->evaluate($this->hasSeconds);
    }

    public function hasTime(): bool
    {
        return (bool) $this->evaluate($this->hasTime);
    }

    public function getHoursStep(): int
    {
        return $this->evaluate($this->hoursStep) ?? 1;
    }

    public function getMinutesStep(): int
    {
        return $this->evaluate($this->minutesStep) ?? 1;
    }

    public function getSecondsStep(): int
    {
        return $this->evaluate($this->secondsStep) ?? 1;
    }

    public function getStep(): int | float | string | null
    {
        $step = $this->evaluate($this->step);

        if (filled($step)) {
            return $step;
        }

        if (! $this->hasTime()) {
            return null;
        }

        $secondsStep = $this->getSecondsStep();

        if ($secondsStep > 1) {
            return $secondsStep;
        }

        $minutesStep = $this->getMinutesStep();

        if ($minutesStep > 1) {
            return $minutesStep * 60;
        }

        $hoursStep = $this->getHoursStep();

        if ($hoursStep > 1) {
            return $hoursStep * 3600;
        }

        if (! $this->hasSeconds()) {
            return null;
        }

        return 1;
    }

    public function getType(): string
    {
        if (! $this->hasDate()) {
            return 'time';
        }

        if (! $this->hasTime()) {
            return 'date';
        }

        return 'datetime-local';
    }
}
