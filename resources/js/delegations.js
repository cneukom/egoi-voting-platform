import $ from 'jquery';

export function initDeleteEvidence() {
    let $contestant;
    let $evidence;
    const $modal = $('#deleteEvidenceModal');

    $('.delete-evidence').on('click', function () {
        $evidence = $(this).parents('[data-id]');
        $contestant = $evidence.parents('[data-contestant-id]');
        $modal.find('[data-contestant]').text($contestant.find('[data-contestant]').text());
        $modal.find('[data-evidence]').text($evidence.find('[data-evidence]').text());
        $modal.modal();
    });

    $modal.find('[data-action]').on('click', function () {
        axios.delete('contestants/' + $contestant.data('contestantId') + '/evidence/' + $evidence.data('id'))
            .then(() => {
                $evidence.remove();
                $modal.modal('hide');
            })
            .catch(() => alert('Could not delete'));
    });
}

export default function initAll() {
    initDeleteEvidence();
}
