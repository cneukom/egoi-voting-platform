import initCloseVote from "./vote/close";

require('./bootstrap');
import 'bootstrap';
import initAnswerOptions from './vote/create';
import $ from 'jquery';
import initNow from "./vote/now";

$(function () {
    initAnswerOptions();
    initCloseVote();
    initNow();
});
