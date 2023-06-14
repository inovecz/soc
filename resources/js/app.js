import './bootstrap';
import Alpine from 'alpinejs';
import flatpickr from 'flatpickr'
import 'flatpickr/dist/l10n/cs.js'
import {delegate} from "tippy.js";
import persist from '@alpinejs/persist'

window.Alpine = Alpine;
Alpine.plugin(persist)
Alpine.start();

window.flatpickr = flatpickr;
flatpickr("#datepicker", {
    locale: "cs"
});

delegate('body', {
    theme: 'light',
    interactive: true,
    allowHTML: true,
    target: '[data-tippy-content]',
    delay: 50,
});
