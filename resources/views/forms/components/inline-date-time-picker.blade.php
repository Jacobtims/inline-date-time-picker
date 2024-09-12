@php
    use Filament\Support\Facades\FilamentView;
    use Jacobtims\InlineDateTimePicker\InlineDateTimePickerServiceProvider;

    $extraAlpineAttributes = $getExtraAlpineAttributes();
    $hasTime = $hasTime();
    $id = $getId();
    $isDisabled = $isDisabled();
    $maxDate = $getMaxDate();
    $minDate = $getMinDate();
    $statePath = $getStatePath();
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    :inline-label-vertical-alignment="\Filament\Support\Enums\VerticalAlignment::Center"
>
    <div
        x-ignore
        @if (FilamentView::hasSpaMode())
            {{-- format-ignore-start --}}ax-load="visible || event (ax-modal-opened)"{{-- format-ignore-end --}}
        @else
            ax-load
        @endif
        ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('inline-date-time-picker', InlineDateTimePickerServiceProvider::$assetPackageName) }}"
        x-data="inlineDateTimePickerFormComponent({
            firstDayOfWeek: {{ $getFirstDayOfWeek() }},
            locale: @js($getLocale()),
            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
        })"
        {{
            $attributes
                ->merge($getExtraAttributes(), escape: false)
                ->merge($getExtraAlpineAttributes(), escape: false)
                ->class(['fi-fo-date-time-picker max-w-sm'])
        }}
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
            wire:key="{{ $this->getId() }}.{{ $statePath }}.{{ $field::class }}.panel"
            @class([
                'fi-fo-date-time-picker-panel rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-950/10 dark:bg-gray-900 dark:ring-white/10',
            ])
        >
            <div class="grid gap-y-3">
                @if ($hasDate())
                    <div class="flex items-center justify-between">
                        <select
                            x-model="focusedMonth"
                            class="grow cursor-pointer border-none bg-transparent p-0 text-sm font-medium text-gray-950 focus:ring-0 dark:bg-gray-900 dark:text-white"
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
                            class="w-16 border-none bg-transparent p-0 text-right text-sm text-gray-950 focus:ring-0 dark:text-white"
                        />
                    </div>

                    <div class="grid grid-cols-7 gap-1">
                        <template
                            x-for="(day, index) in dayLabels"
                            x-bind:key="index"
                        >
                            <div
                                x-text="day"
                                class="text-center text-xs font-medium text-gray-500 dark:text-gray-400"
                            ></div>
                        </template>
                    </div>

                    <div
                        role="grid"
                        class="grid grid-cols-[repeat(7,minmax(theme(spacing.7),1fr))] gap-1"
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
                                    'text-gray-950 dark:text-white': ! dayIsToday(day) && ! dayIsSelected(day),
                                    'cursor-pointer': ! dayIsDisabled(day),
                                    'text-primary-600 dark:text-primary-400':
                                        dayIsToday(day) &&
                                        ! dayIsSelected(day) &&
                                        focusedDate.date() !== day &&
                                        ! dayIsDisabled(day),
                                    'bg-gray-50 dark:bg-white/5':
                                        focusedDate.date() === day &&
                                        ! dayIsSelected(day) &&
                                        ! dayIsDisabled(day),
                                    'text-primary-600 bg-gray-50 dark:bg-white/5 dark:text-primary-400':
                                        dayIsSelected(day),
                                    'pointer-events-none': dayIsDisabled(day),
                                    'opacity-50': dayIsDisabled(day),
                                }"
                                class="rounded-full text-center text-sm leading-loose transition duration-75"
                            ></div>
                        </template>
                    </div>
                @endif

                @if ($hasTime)
                    <div
                        class="flex items-center justify-center rtl:flex-row-reverse"
                    >
                        <input
                            max="23"
                            min="0"
                            step="{{ $getHoursStep() }}"
                            type="number"
                            inputmode="numeric"
                            x-model.debounce="hour"
                            class="me-1 w-10 border-none bg-transparent p-0 text-center text-sm text-gray-950 focus:ring-0 dark:text-white"
                        />

                        <span
                            class="text-sm font-medium text-gray-500 dark:text-gray-400"
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
                            class="me-1 w-10 border-none bg-transparent p-0 text-center text-sm text-gray-950 focus:ring-0 dark:text-white"
                        />

                        @if ($hasSeconds())
                            <span
                                class="text-sm font-medium text-gray-500 dark:text-gray-400"
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
                                class="me-1 w-10 border-none bg-transparent p-0 text-center text-sm text-gray-950 focus:ring-0 dark:text-white"
                            />
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dynamic-component>
