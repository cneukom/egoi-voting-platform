require('./bootstrap');
import 'bootstrap';
import initAll from './delegations';
import $ from 'jquery';

$(function () {
    const matches = location.pathname.match(/\/delegation\/([0-9]+)\/([a-z0-9]+)$/i);
    if (matches) {
        axios.defaults.baseURL = '/api/delegation/' + matches[1] + '/' + matches[2] + '/';
        initAll();
    }
});
