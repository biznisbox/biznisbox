<template>
    <DefaultLayout>
        <PageHeader :title="$t('calendar.calendar')">
            <template v-slot:actions>
                <Button :label="$t('calendar.new_event')" icon="fa fa-plus" @click="openNewEventDialog" />
            </template>
        </PageHeader>
        <div id="calendar" class="card">
            <FullCalendar ref="calendar" :options="calendarOptions" />
        </div>

        <!-- Dialog event -->
        <Dialog
            v-model:visible="showEventDialog"
            :header="method === 'edit' ? $t('calendar.edit_event') : $t('calendar.new_event')"
            class="w-full m-2 lg:w-1/2"
            modal
        >
            <LoadingScreen :blocked="loadingData">
                <Tabs value="event_details">
                    <TabList>
                        <Tab value="event_details">{{ $t('calendar.event_details') }}</Tab>
                        <Tab value="attendees">{{ $t('calendar.attendees') }}</Tab>
                    </TabList>

                    <TabPanels>
                        <!-- Event details -->
                        <TabPanel value="event_details">
                            <form>
                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-2">
                                    <TextInput
                                        id="title_input"
                                        class="lg:col-span-10"
                                        v-model="v$.event.title.$model"
                                        :label="$t('form.title')"
                                        :validate="v$.event.title"
                                    />
                                    <div class="lg:col-span-2">
                                        <div class="flex flex-col gap-2 mb-2">
                                            <label for="color_input" class="dark:text-surface-200">{{ $t('form.color') }}</label>
                                            <ColorPicker id="color_input" v-model="event.color" />
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-2">
                                    <DateInput
                                        id="start_input"
                                        v-model="v$.event.start.$model"
                                        class="lg:col-span-5"
                                        :label="$t('form.start_date')"
                                        :show-time="!event.all_day"
                                        :validate="v$.event.start"
                                    ></DateInput>
                                    <DateInput
                                        id="end_input"
                                        v-model="v$.event.end.$model"
                                        class="lg:col-span-5"
                                        :label="$t('form.end_date')"
                                        :show-time="!event.all_day"
                                        :validate="v$.event.end"
                                    />
                                    <div class="flex items-center gap-2 lg:col-span-1">
                                        <label class="dark:text-surface-200" for="all_day_input">{{ $t('form.all_day') }}</label>
                                        <Checkbox id="all_day_input" v-model="event.all_day" name="all_day" binary />
                                    </div>
                                </div>

                                <div class="grid">
                                    <TextInput id="location_input" v-model="event.location" :label="$t('form.location')" />
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                                    <SelectInput
                                        id="show_as_input"
                                        v-model="v$.event.show_as.$model"
                                        :label="$t('form.show_me_as')"
                                        :options="[
                                            { value: 'free', label: $t('show_as.free') },
                                            { value: 'busy', label: $t('show_as.busy') },
                                            { value: 'tentative', label: $t('show_as.tentative') },
                                            { value: 'out_of_office', label: $t('show_as.out_of_office') },
                                        ]"
                                        :validate="v$.event.show_as"
                                    />
                                    <SelectInput
                                        id="status_input"
                                        v-model="v$.event.status.$model"
                                        :label="$t('form.status')"
                                        :options="[
                                            { value: 'accepted', label: $t('status.accepted') },
                                            { value: 'declined', label: $t('status.declined') },
                                            { value: 'tentative', label: $t('status.tentative') },
                                            { value: 'needs_action', label: $t('status.needs_action') },
                                            { value: 'delegated', label: $t('status.delegated') },
                                        ]"
                                        :validate="v$.event.status"
                                    />
                                </div>

                                <TinyMceEditor
                                    id="description_input"
                                    v-model="event.description"
                                    :label="$t('form.description')"
                                    toolbar="bold italic underline | alignleft aligncenter alignright alignjustify | fontselect fontsizeselect formatselect |forecolor backcolor removeformat | charmap |  bullist numlist outdent indent"
                                />
                            </form>
                        </TabPanel>

                        <!-- Attendees -->
                        <TabPanel value="attendees">
                            <div class="my-2">
                                <Button :label="$t('calendar.add_attendee')" icon="fa fa-plus" @click="addAttendee" />
                            </div>

                            <DataTable class="overflow-x-auto" :value="event.attendees">
                                <template #empty>
                                    <div class="flex items-center justify-center p-3">
                                        <span class="dark:text-surface-200">{{ $t('calendar.no_attendees') }}</span>
                                    </div>
                                </template>

                                <Column field="name" :header="$t('form.name')">
                                    <template #body="slotProps">
                                        <TextInput :id="`name_input_${slotProps.index}`" v-model="slotProps.data.name" />
                                    </template>
                                </Column>

                                <Column field="email" :header="$t('form.email')">
                                    <template #body="slotProps">
                                        <TextInput :id="`email_input_${slotProps.index}`" v-model="slotProps.data.email" />
                                    </template>
                                </Column>

                                <Column field="role" :header="$t('form.role')">
                                    <template #body="slotProps">
                                        <SelectInput
                                            :id="`role_input_${slotProps.index}`"
                                            v-model="slotProps.data.role"
                                            :options="[
                                                { value: 'required', label: $t('calendar.required') },
                                                { value: 'optional', label: $t('calendar.optional') },
                                            ]"
                                        />
                                    </template>
                                </Column>

                                <Column field="status" :header="$t('form.status')">
                                    <template #body="slotProps">
                                        <SelectInput
                                            :id="`status_input_${slotProps.index}`"
                                            v-model="slotProps.data.status"
                                            :options="[
                                                { value: 'accepted', label: $t('status.accepted') },
                                                { value: 'declined', label: $t('status.declined') },
                                                { value: 'tentative', label: $t('status.tentative') },
                                                { value: 'needs_action', label: $t('status.needs_action') },
                                                { value: 'delegated', label: $t('status.delegated') },
                                            ]"
                                        />
                                    </template>
                                </Column>

                                <Column :header="$t('basic.actions')">
                                    <template #body="slotProps">
                                        <Button
                                            icon="fa fa-trash"
                                            @click="removeAttendee(slotProps.index)"
                                            severity="danger"
                                            :id="`remove_item_button_${slotProps.index}`"
                                        />
                                    </template>
                                </Column>
                            </DataTable>
                        </TabPanel>
                    </TabPanels>
                </Tabs>
            </LoadingScreen>

            <template #footer>
                <div id="function_buttons" class="flex justify-end gap-2">
                    <Button :label="$t('basic.cancel')" icon="fa fa-times" @click="showEventDialog = false" severity="secondary" />
                    <Button
                        :label="$t('basic.delete')"
                        icon="fa fa-trash"
                        @click="deleteEventAsk(event.id)"
                        :disabled="loadingData"
                        severity="danger"
                        v-if="method === 'edit'"
                    />
                    <Button
                        :label="method === 'edit' ? $t('basic.update') : $t('basic.save')"
                        icon="fa fa-floppy-disk"
                        :disabled="loadingData"
                        severity="success"
                        @click="saveUpdateEvent(method)"
                    />
                </div>
            </template>
        </Dialog>
    </DefaultLayout>
</template>

<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid'
import rrulePlugin from '@fullcalendar/rrule'
import allLocales from '@fullcalendar/core/locales-all'
import axios from 'axios'
import { useCookies } from 'vue3-cookies'
const { cookies } = useCookies()
import CalendarMixin from '@/mixins/calendar'
import { required } from '@/plugins/i18n-validators'
import { useVuelidate } from '@vuelidate/core'
export default {
    name: 'CalendarPage',
    mixins: [CalendarMixin],
    components: {
        FullCalendar,
    },
    setup() {
        return { v$: useVuelidate() }
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
                            console.log(error)
                            failureCallback(error)
                        })
                },
            },
            showEventDialog: false,
            method: 'create', // edit or create
        }
    },
    validations() {
        return {
            event: {
                title: { required },
                start: { required },
                end: { required },
                show_as: { required },
                status: { required },
            },
        }
    },
    methods: {
        saveUpdateEvent(method) {
            this.v$.event.$touch()
            if (this.v$.event.$invalid) {
                this.showToast(this.$t('basic.invalid_form'), this.$t('basic.error'), 'error')
                return
            }

            if (method === 'edit') {
                this.updateEvent(this.event.id)
            }
            if (method === 'create') {
                this.createEvent()
                this.showEventDialog = false
            }
            this.resetCalendar()
        },

        viewEvent(info) {
            this.resetCalendar()
            this.method = 'edit'
            this.getEvent(info.event.id)
            this.showEventDialog = true
        },

        handleDateClick(info) {
            this.method = 'create'
            this.event = {
                title: '',
                start: info.dateStr,
                end: info.dateStr,
                all_day: true,
                color: '#007bff',
                show_as: 'busy',
                status: 'confirmed',
                description: '',
                attendees: [],
            }
            this.showEventDialog = true
        },

        resetCalendar() {
            this.v$.event.$reset()
            this.event = {
                title: '',
                start: '',
                end: '',
                all_day: true,
                color: '#007bff',
                show_as: 'busy',
                status: 'confirmed',
                description: '',
                attendees: [],
            }
        },

        openNewEventDialog() {
            this.method = 'create'
            this.resetCalendar()
            this.showEventDialog = true
        },

        handleSelect(info) {
            this.method = 'create'
            this.resetEvent(info.startStr, info.endStr)
            this.showEventDialog = true
        },

        addAttendee() {
            this.event.attendees.push({
                email: '',
                name: '',
                role: 'required',
                status: 'needs_action',
            })
        },

        removeAttendee(index) {
            this.event.attendees.splice(index, 1)
        },
    },
}
</script>
<style></style>
