<template>
    <user-layout>
        <div id="calendar_page">
            <user-header :title="$t('calendar.calendar')">
                <template #actions>
                    <Button :label="$t('calendar.new_event')" icon="fa fa-plus" @click="showNewEventDialog = true" />
                </template>
            </user-header>

            <div id="calendar" class="card">
                <FullCalendar ref="calendar" :options="calendarOptions" />
            </div>

            <!-- Dialog new event -->
            <Dialog v-model:visible="showNewEventDialog" :header="$t('calendar.new_event')" maximizable modal>
                <form class="formgrid">
                    <div class="grid">
                        <TextInput
                            id="title_input"
                            v-model="v$.event.title.$model"
                            class="field col-12 md:col-10"
                            :label="$t('calendar.event_title')"
                            :validate="v$.event.title"
                        ></TextInput>
                        <ColorPicker v-model="event.color" class="field col-12 md:col-2"></ColorPicker>
                    </div>

                    <div class="grid">
                        <DateInput
                            id="start_input"
                            v-model="event.start"
                            class="field col-12 md:col-5"
                            :label="$t('calendar.event_start')"
                            :show-time="!event.all_day"
                        ></DateInput>
                        <DateInput
                            id="end_input"
                            v-model="event.end"
                            class="field col-12 md:col-5"
                            :label="$t('calendar.event_end')"
                            :show-time="!event.all_day"
                        ></DateInput>
                        <div class="field-checkbox col-12 md:col-1">
                            <Checkbox id="all_day_input" v-model="event.all_day" name="all_day" binary></Checkbox>
                            <label class=" ">{{ $t('calendar.all_day') }}</label>
                        </div>
                    </div>

                    <div class="grid">
                        <TextInput
                            id="location_input"
                            v-model="event.location"
                            class="field col-12"
                            :label="$t('calendar.event_location')"
                        ></TextInput>
                    </div>

                    <div class="grid">
                        <SelectInput
                            id="show_as_input"
                            v-model="event.show_as"
                            class="field col-12 md:col-6"
                            :label="$t('calendar.show_me_as')"
                            :options="[
                                { value: 'free', label: $t('calendar.free') },
                                { value: 'busy', label: $t('calendar.busy') },
                                { value: 'tentative', label: $t('calendar.tentative') },
                                { value: 'outofoffice', label: $t('calendar.outofoffice') },
                            ]"
                        ></SelectInput>
                        <SelectInput
                            id="status_input"
                            v-model="event.status"
                            class="field col-12 md:col-6"
                            :label="$t('calendar.event_status')"
                            :options="[
                                { value: 'confirmed', label: $t('calendar.confirmed') },
                                { value: 'tentative', label: $t('calendar.tentative') },
                                { value: 'cancelled', label: $t('calendar.cancelled') },
                            ]"
                        ></SelectInput>
                    </div>

                    <div class="grid">
                        <TinyMceEditor
                            id="description_input"
                            v-model="event.description"
                            class="field col-12"
                            :label="$t('calendar.event_description')"
                            toolbar="bold italic underline | alignleft aligncenter alignright alignjustify | fontselect fontsizeselect formatselect |forecolor backcolor removeformat | charmap |  bullist numlist outdent indent"
                        />
                    </div>
                </form>

                <template #footer>
                    <div id="function_buttons" class="grid gap-2 justify-content-end">
                        <Button
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            class="p-button-danger"
                            @click="showNewEventDialog = false"
                        />
                        <Button
                            :label="$t('basic.save')"
                            icon="fa fa-floppy-disk"
                            :disabled="loadingData"
                            class="p-button-success"
                            @click="validateForm('create')"
                        />
                    </div>
                </template>
            </Dialog>

            <!-- Dialog edit event -->
            <Dialog v-model:visible="showEditEventDialog" :header="$t('calendar.edit_event')" :maximizable="true" :modal="true">
                <LoadingScreen :blocked="loadingData">
                    <form class="formgrid">
                        <div class="grid">
                            <TextInput
                                id="title_input"
                                v-model="v$.event.title.$model"
                                class="field col-12 md:col-10"
                                :label="$t('calendar.event_title')"
                                :validate="v$.event.title"
                            ></TextInput>
                            <ColorPicker v-model="event.color" class="field col-12 md:col-2"></ColorPicker>
                        </div>

                        <div class="grid">
                            <DateInput
                                id="start_input"
                                v-model="event.start"
                                class="field col-12 md:col-5"
                                :label="$t('calendar.event_start')"
                                :show-time="!event.all_day"
                            ></DateInput>
                            <DateInput
                                id="end_input"
                                v-model="event.end"
                                class="field col-12 md:col-5"
                                :label="$t('calendar.event_end')"
                                :show-time="!event.all_day"
                            ></DateInput>
                            <div class="field-checkbox col-12 md:col-1">
                                <Checkbox id="all_day_input" v-model="event.all_day" name="all_day" binary></Checkbox>
                                <label class=" ">{{ $t('calendar.all_day') }}</label>
                            </div>
                        </div>

                        <div class="grid">
                            <TextInput
                                id="location_input"
                                v-model="event.location"
                                class="field col-12"
                                :label="$t('calendar.event_location')"
                            ></TextInput>
                        </div>

                        <div class="grid">
                            <SelectInput
                                id="show_as_input"
                                v-model="event.show_as"
                                class="field col-12 md:col-6"
                                :label="$t('calendar.show_me_as')"
                                :options="[
                                    { value: 'free', label: $t('calendar.free') },
                                    { value: 'busy', label: $t('calendar.busy') },
                                    { value: 'tentative', label: $t('calendar.tentative') },
                                    { value: 'outofoffice', label: $t('calendar.outofoffice') },
                                ]"
                            ></SelectInput>
                            <SelectInput
                                id="status_input"
                                v-model="event.status"
                                class="field col-12 md:col-6"
                                :label="$t('calendar.event_status')"
                                :options="[
                                    { value: 'confirmed', label: $t('calendar.confirmed') },
                                    { value: 'tentative', label: $t('calendar.tentative') },
                                    { value: 'cancelled', label: $t('calendar.cancelled') },
                                ]"
                            ></SelectInput>
                        </div>

                        <div class="grid">
                            <TinyMceEditor
                                id="description_input"
                                v-model="event.description"
                                class="field col-12"
                                :label="$t('calendar.event_description')"
                                toolbar="bold italic underline | alignleft aligncenter alignright alignjustify | fontselect fontsizeselect formatselect |forecolor backcolor removeformat | charmap |  bullist numlist outdent indent"
                            />
                        </div>
                    </form>
                </LoadingScreen>
                <template #footer>
                    <div id="function_buttons" class="grid gap-2 justify-content-end">
                        <Button
                            :label="$t('basic.delete')"
                            icon="fa fa-trash"
                            class="p-button-danger"
                            @click="dialogDeleteEvent(event.id)"
                        />
                        <Button
                            :label="$t('basic.cancel')"
                            icon="fa fa-times"
                            class="p-button-danger"
                            @click="showEditEventDialog = false"
                        />
                        <Button
                            :label="$t('basic.update')"
                            :disabled="loadingData"
                            icon="fa fa-floppy-disk"
                            class="p-button-success"
                            @click="validateForm('update')"
                        />
                    </div>
                </template>
            </Dialog>
        </div>
    </user-layout>
</template>

<script>
import { required } from '@vuelidate/validators'
import { useVuelidate } from '@vuelidate/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import rrulePlugin from '@fullcalendar/rrule'
import allLocales from '@fullcalendar/core/locales-all'
import CalendarMixin from '@/mixins/calendar'
import axios from 'axios'
import { useCookies } from 'vue3-cookies'
const { cookies } = useCookies()

export default {
    name: 'CalendarPage',
    mixins: [CalendarMixin],
    setup: () => ({ v$: useVuelidate() }),

    validations() {
        return {
            event: {
                title: { required },
            },
        }
    },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin, rrulePlugin],
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay',
                },
                locales: allLocales,
                locale: this.$i18n.locale,
                selectable: true,
                dateClick: this.handleDateClick,
                eventClick: this.viewEvent,
                select: this.handleSelect,
                navLinks: true,
                eventSources: function (info, successCallback, failureCallback) {
                    axios
                        .get('/api/calendar/events', {
                            params: {
                                start: info.startStr,
                                end: info.endStr,
                            },
                            headers: {
                                Accept: 'application/json',
                                Authorization: 'Bearer ' + cookies.get('token'),
                            },
                        })
                        .then((response) => {
                            successCallback(response.data.data)
                        })
                        .catch((error) => {
                            this.showToast(this.$t('basic.error'), this.$t('basic.error'), 'error')
                            failureCallback(error)
                        })
                },
            },
            showNewEventDialog: false,
            showEditEventDialog: false,
        }
    },
    methods: {
        handleDateClick(arg) {
            this.setEvent(arg)
            this.showNewEventDialog = true
        },

        handleSelect(arg) {
            this.setEvent(arg, 'select_date')
            this.showNewEventDialog = true
        },

        viewEvent(arg) {
            this.getEvent(arg.event.id)
            this.showEditEventDialog = true
        },

        dialogSaveEvent() {
            this.saveEvent()
            this.clearEvent()
            this.showNewEventDialog = false
        },

        dialogUpdateEvent() {
            this.updateEvent(this.event.id)
            this.clearEvent()
            this.showEditEventDialog = false
        },

        dialogDeleteEvent(id) {
            this.deleteEvent(id)
            this.clearEvent()
            this.showEditEventDialog = false
        },

        clearEvent() {
            this.v$.$reset()
            this.event = {
                title: '',
                start: '',
                end: '',
                color: '007bff',
                all_day: false,
                location: '',
                show_as: 'free',
                status: 'confirmed',
                description: '',
            }
        },

        setEvent(event, type = 'date_click') {
            if (type === 'date_click') {
                this.v$.$reset()
                this.event = {
                    title: '',
                    start: event.date,
                    end: event.date,
                    all_day: event.allDay,
                    location: '',
                    color: '007bff',
                    show_as: 'free',
                    status: 'confirmed',
                    description: '',
                }
            } else {
                this.v$.$reset()
                this.event = {
                    title: '',
                    start: event.start,
                    end: event.end,
                    all_day: false,
                    location: '',
                    color: '007bff',
                    show_as: 'free',
                    status: 'confirmed',
                    description: '',
                }
            }
        },

        validateForm(fun) {
            this.v$.$touch()
            if (this.v$.$error) {
                return this.showToast(this.$t('basic.error'), this.$t('basic.invalid_form'), 'error')
            }

            if (fun == 'create') {
                this.v$.$reset()
                return this.dialogSaveEvent()
            }
            if (fun == 'update') {
                this.v$.$reset()
                return this.dialogUpdateEvent(this.event.id)
            }
        },
    },
}
</script>

<style></style>
