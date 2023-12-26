/*
 * PRIMEVUE plugin
 * https://www.primefaces.org/primevue/
 *
 * There are imports for only the PrimeVue components used in the project.
 */
import PrimeVue from 'primevue/config'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import InputNumber from 'primevue/inputnumber'
import InputMask from 'primevue/inputmask'
import InputSwitch from 'primevue/inputswitch'
import Password from 'primevue/password'
import Dropdown from 'primevue/dropdown'
import Dialog from 'primevue/dialog'
import DialogService from 'primevue/dialogservice'
import MultiSelect from 'primevue/multiselect'
import CascadeSelect from 'primevue/cascadeselect'
import Divider from 'primevue/divider'
import OverlayPanel from 'primevue/overlaypanel'
import Sidebar from 'primevue/sidebar'
import FileUpload from 'primevue/fileupload'
import ContextMenu from 'primevue/contextmenu'
import Menu from 'primevue/menu'
import Steps from 'primevue/steps'
import TabMenu from 'primevue/tabmenu'
import ToastService from 'primevue/toastservice'
import Avatar from 'primevue/avatar'
import AvatarGroup from 'primevue/avatargroup'
import Badge from 'primevue/badge'
import BlockUI from 'primevue/blockui'
import Breadcrumb from 'primevue/breadcrumb'
import ScrollTop from 'primevue/scrolltop'
import Skeleton from 'primevue/skeleton'
import ProgressBar from 'primevue/progressbar'
import ProgressSpinner from 'primevue/progressspinner'
import Tag from 'primevue/tag'
import Message from 'primevue/message'
import Tooltip from 'primevue/tooltip'
import ConfirmationService from 'primevue/confirmationservice'
import Calendar from 'primevue/calendar'
import Checkbox from 'primevue/checkbox'
import RadioButton from 'primevue/radiobutton'
import Slider from 'primevue/slider'
import Rating from 'primevue/rating'
import SelectButton from 'primevue/selectbutton'
import ColorPicker from 'primevue/colorpicker'
import AutoComplete from 'primevue/autocomplete'
import Chips from 'primevue/chips'
import Listbox from 'primevue/listbox'
import PickList from 'primevue/picklist'
import OrderList from 'primevue/orderlist'
import Carousel from 'primevue/carousel'
import DataView from 'primevue/dataview'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import ColumnGroup from 'primevue/columngroup'
import VirtualScroller from 'primevue/virtualscroller'
import Tree from 'primevue/tree'
import TreeTable from 'primevue/treetable'
import TabView from 'primevue/tabview'
import TabPanel from 'primevue/tabpanel'
import Accordion from 'primevue/accordion'
import AccordionTab from 'primevue/accordiontab'
import Fieldset from 'primevue/fieldset'
import Toolbar from 'primevue/toolbar'
import ScrollPanel from 'primevue/scrollpanel'
import Card from 'primevue/card'
import Panel from 'primevue/panel'
import Splitter from 'primevue/splitter'
import SplitterPanel from 'primevue/splitterpanel'
import Galleria from 'primevue/galleria'
import Toast from 'primevue/toast'
import Row from 'primevue/row'
import ConfirmDialog from 'primevue/confirmdialog'
import ConfirmPopup from 'primevue/confirmpopup'
import TriStateCheckbox from 'primevue/tristatecheckbox'
import TreeSelect from 'primevue/treeselect'
import TextArea from 'primevue/textarea'
import Chart from 'primevue/chart'
import SpeedDial from 'primevue/speeddial'

export default {
    install(app) {
        app.use(PrimeVue)
        app.use(ConfirmationService)
        app.use(DialogService)
        app.use(ToastService)
        app.directive('tooltip', Tooltip)
        app.component('Button', Button)
        app.component('InputText', InputText)
        app.component('InputNumber', InputNumber)
        app.component('InputMask', InputMask)
        app.component('InputSwitch', InputSwitch)
        app.component('Password', Password)
        app.component('Dropdown', Dropdown)
        app.component('MultiSelect', MultiSelect)
        app.component('Calendar', Calendar)
        app.component('Checkbox', Checkbox)
        app.component('RadioButton', RadioButton)
        app.component('Slider', Slider)
        app.component('Rating', Rating)
        app.component('SelectButton', SelectButton)
        app.component('ColorPicker', ColorPicker)
        app.component('AutoComplete', AutoComplete)
        app.component('Chips', Chips)
        app.component('Listbox', Listbox)
        app.component('PickList', PickList)
        app.component('OrderList', OrderList)
        app.component('Carousel', Carousel)
        app.component('DataView', DataView)
        app.component('DataTable', DataTable)
        app.component('Column', Column)
        app.component('ColumnGroup', ColumnGroup)
        app.component('VirtualScroller', VirtualScroller)
        app.component('Tree', Tree)
        app.component('TreeTable', TreeTable)
        app.component('TabView', TabView)
        app.component('TabPanel', TabPanel)
        app.component('Accordion', Accordion)
        app.component('AccordionTab', AccordionTab)
        app.component('Fieldset', Fieldset)
        app.component('Toolbar', Toolbar)
        app.component('ScrollPanel', ScrollPanel)
        app.component('Card', Card)
        app.component('Panel', Panel)
        app.component('Splitter', Splitter)
        app.component('SplitterPanel', SplitterPanel)
        app.component('Galleria', Galleria)
        app.component('CascadeSelect', CascadeSelect)
        app.component('Divider', Divider)
        app.component('Dialog', Dialog)
        app.component('OverlayPanel', OverlayPanel)
        app.component('Sidebar', Sidebar)
        app.component('FileUpload', FileUpload)
        app.component('ContextMenu', ContextMenu)
        app.component('Menu', Menu)
        app.component('Steps', Steps)
        app.component('TabMenu', TabMenu)
        app.component('Message', Message)
        app.component('Avatar', Avatar)
        app.component('AvatarGroup', AvatarGroup)
        app.component('Badge', Badge)
        app.component('BlockUI', BlockUI)
        app.component('Breadcrumb', Breadcrumb)
        app.component('ScrollTop', ScrollTop)
        app.component('Skeleton', Skeleton)
        app.component('ProgressBar', ProgressBar)
        app.component('ProgressSpinner', ProgressSpinner)
        app.component('Tag', Tag)
        app.component('Toast', Toast)
        app.component('Row', Row)
        app.component('ConfirmDialog', ConfirmDialog)
        app.component('ConfirmPopup', ConfirmPopup)
        app.component('TriStateCheckbox', TriStateCheckbox)
        app.component('TreeSelect', TreeSelect)
        app.component('TextArea', TextArea)
        app.component('Chart', Chart)
        app.component('SpeedDial', SpeedDial)
    },
}
