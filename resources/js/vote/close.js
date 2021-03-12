import $ from 'jquery';

export default function initCloseVote() {
    $('[data-close-vote]').on('click', function() {
        $(this).parent().find('form').submit();
    });
}
