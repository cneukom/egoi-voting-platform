import $ from 'jquery';

export default function initOverview() {
    $('.evidence-badge[data-id]').on('click', function () {
        const evidenceId = $(this).data('id');
        axios.get('evidence/' + evidenceId)
            .then((response) => open(response.data.url))
            .catch(() => alert('Error while getting download URL'));
    });
}
