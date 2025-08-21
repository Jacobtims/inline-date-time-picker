@php
    use Filament\Support\Enums\VerticalAlignment;
    use Filament\Support\Facades\FilamentAsset;
    use Filament\Support\Facades\FilamentView;
    use Jacobtims\InlineDateTimePicker\InlineDateTimePickerServiceProvider;

    use function Filament\Support\prepare_inherited_attributes;

    $fieldWrapperView = $getFieldWrapperView();
    $extraAlpineAttributes = $getExtraAlpineAttributes();
    $extraAttributeBag = $getExtraAttributeBag();
    $hasTime = $hasTime();
    $id = $getId();
    $isDisabled = $isDisabled();
    $maxDate = $getMaxDate();
    $minDate = $getMinDate();
    $statePath = $getStatePath();
    $livewireKey = $getLivewireKey();
@endphp

<x-dynamic-component
    :component="$fieldWrapperView"
    :field="$field"
    :inline-label-vertical-alignment="VerticalAlignment::Center"
>
    <x-filament::input.wrapper
        :disabled="$isDisabled"
        :valid="! $errors->has($statePath)"
        :attributes="prepare_inherited_attributes($extraAttributeBag)->class(['fi-fo-inline-date-time-picker'])"
    >
        <div
            x-load
            x-load-src="{{ FilamentAsset::getAlpineComponentSrc('inline-date-time-picker', InlineDateTimePickerServiceProvider::$assetPackageName) }}"
            x-data="inlineDateTimePickerFormComponent({
                firstDayOfWeek: {{ $getFirstDayOfWeek() }},
                locale: @js($getLocale()),
                state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
            })"
            wire:ignore
            wire:key="{{ $livewireKey }}.{{
                substr(md5(serialize([
                    $isDisabled,
                    $maxDate,
                    $minDate,
                ])), 0, 64)
            }}"
            {{ $getExtraAlpineAttributeBag() }}
        >
            <input x-ref="maxDate" type="hidden" value="{{ $maxDate }}" />

            <input x-ref="minDate" type="hidden" value="{{ $minDate }}" />

            <input
                x-ref="disabledDates"
                type="hidden"
                value="{{ json_encode($getDisabledDates()) }}"
            />

            <div
                x-ref="panel"
                x-cloak
                wire:ignore
                wire:key="{{ $livewireKey }}.panel"
                @class([
                    'fi-fo-inline-date-time-picker-panel',
                ])
            >
                @if ($hasDate())
                    <div class="fi-fo-inline-date-time-picker-panel-header">
                        <select
                            x-model="focusedMonth"
                            class="fi-fo-inline-date-time-picker-month-select"
                        >
                            <template
                                x-for="(month, index) in months"
                            >
                                <option
                                    x-bind:value="index"
                                    x-text="month"
                                ></option>
                            </template>
                        </select>

                        <input
                            type="number"
                            inputmode="numeric"
                            x-model.debounce="focusedYear"
                            class="fi-fo-inline-date-time-picker-year-input"
                        />
                    </div>

                    <div class="fi-fo-inline-date-time-picker-calendar-header">
                        <template
                            x-for="(day, index) in dayLabels"
                            x-bind:key="index"
                        >
                            <div
                                x-text="day"
                                class="fi-fo-inline-date-time-picker-calendar-header-day"
                            ></div>
                        </template>
                    </div>

                    <div
                        role="grid"
                        class="fi-fo-inline-date-time-picker-calendar"
                    >
                        <template
                            x-for="day in emptyDaysInFocusedMonth"
                            x-bind:key="day"
                        >
                            <div></div>
                        </template>

                        <template
                            x-for="day in daysInFocusedMonth"
                            x-bind:key="day"
                        >
                            <div
                                x-text="day"
                                x-on:click="dayIsDisabled(day) || selectDate(day)"
                                x-on:mouseenter="setFocusedDay(day)"
                                role="option"
                                x-bind:aria-selected="focusedDate.date() === day"
                                x-bind:class="{
                                    'fi-fo-inline-date-time-picker-calendar-day-today': dayIsToday(day),
                                    'fi-focused': focusedDate.date() === day,
                                    'fi-selected': dayIsSelected(day),
                                    'fi-disabled': dayIsDisabled(day),
                                }"
                                class="fi-fo-inline-date-time-picker-calendar-day"
                            ></div>
                        </template>
                    </div>
                @endif

                @if ($hasTime)
                    <div class="fi-fo-inline-date-time-picker-time-inputs">
                        <input
                            max="23"
                            min="0"
                            step="{{ $getHoursStep() }}"
                            type="number"
                            inputmode="numeric"
                            x-model.debounce="hour"
                        />

                        <span
                            class="fi-fo-inline-date-time-picker-time-input-separator"
                        >
                            :
                        </span>

                        <input
                            max="59"
                            min="0"
                            step="{{ $getMinutesStep() }}"
                            type="number"
                            inputmode="numeric"
                            x-model.debounce="minute"
                        />

                        @if ($hasSeconds())
                            <span
                                class="fi-fo-inline-date-time-picker-time-input-separator"
                            >
                                :
                            </span>

                            <input
                                max="59"
                                min="0"
                                step="{{ $getSecondsStep() }}"
                                type="number"
                                inputmode="numeric"
                                x-model.debounce="second"
                            />
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </x-filament::input.wrapper>
</x-dynamic-component>
