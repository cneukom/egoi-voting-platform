import $ from 'jquery';
import Evidence from "./models/Evidence";

let $deleteEvidenceModal;

function handleErrorWithEvidence($evidenceView) {
    return thrown => {
        if (!axios.isCancel(thrown)) {
            $evidenceView.find('.progress').remove();
            $evidenceView.addClass('text-danger bg-warning');
            $evidenceView[0].draggable = false;
        }
    };
}

function cancelEvidence(cancel) {
    return ($evidenceView) => {
        if (cancel) {
            cancel.cancel();
        }
        if ($evidenceView.data('id')) {
            const $progress = $evidenceView.find('.progress');
            if ($progress.length) {
                $progress.remove();
                deleteEvidence($evidenceView);
            } else {
                confirmDeleteEvidence($evidenceView);
            }
        } else {
            $evidenceView.remove();
        }
    };
}

function confirmDeleteEvidence($evidence) {
    if ($evidence.hasClass('text-danger')) { // upload failed, delete anyways
        deleteEvidence($evidence);
    } else {
        $deleteEvidenceModal.$evidence = $evidence;
        $deleteEvidenceModal.find('[data-contestant]').text($evidence.parents('[data-contestant-id]').find('[data-contestant]').text());
        $deleteEvidenceModal.find('[data-evidence]').text($evidence.find('[data-evidence]').text());
        $deleteEvidenceModal.modal();
    }
}

function deleteEvidence($evidence) {
    const contestantId = $evidence.parents('[data-contestant-id]').data('contestantId');
    const evidenceId = $evidence.data('id');

    $evidence.find('.delete-evidence').remove();
    $evidence.append('<div class="spinner-border spinner-border-sm float-right text-primary" role="status"><span class="sr-only">Loading...</span></div>');
    axios.delete('contestants/' + contestantId + '/evidence/' + evidenceId)
        .then(() => $evidence.remove())
        .catch((error) => {
            if (error.response.status === 403) {
                // that's fine: we are not allowed to delete the evidence because it's not associated to the contestant
                $evidence.remove();
            } else {
                handleErrorWithEvidence($evidence)(error);
            }
        });
}

// checks whether the evidence linked to drag event can be accepted by a drop zone
// note, we cannot distinguish mimetypes before the files are dropped
function canAcceptEvidence($dropZone, evidence) {
    if (evidence) {
        if (evidence.type !== $dropZone.data('evidenceType')) {
            return false; // cannot re-use screenCapture as workScene and vice-versa
        }

        // can link evidence exactly once with each participant
        return $dropZone.find('[data-id="' + evidence.id + '"]').length === 0;
    }
    // otherwise, it might be a video, hence
    return true;
}

// give feedback to the user if we can accept an evidence
function initAcceptEvidence() {
    $('.videos').on('dragover', function (event) {
        const $this = $(this);
        const evidence = Evidence.parse(event.originalEvent.dataTransfer.getData('application/x-egoi-evidence'));
        if (canAcceptEvidence($this, evidence)) {
            $this.addClass('hovered');
        }
    }).on('dragleave', function () {
        $(this).removeClass('hovered');
    });
}

// when video files are dropped, upload them to the S3 bucket
function initUploadEvidence() {
    $('.videos').on('drop', function (event) {
        $(this).removeClass('hovered');
        uploadFiles.call(this, event.originalEvent.dataTransfer.files);
    });

    $('.videos input[type="file"].hidden').on('change', function () {
        uploadFiles.call(this.parentNode, this.files);
    });

    function uploadFiles(files) {
        const evidenceType = $(this).data('evidenceType');
        const contestantId = $(this).parents('[data-contestant-id]').data('contestantId');
        let success = true;
        for (let i = 0; i < files.length; i++) {
            success &= uploadEvidence.call(this, files[i], contestantId, evidenceType);
        }
        if (!success) {
            alert('Only videos are allowed.');
        }
    }

    function uploadEvidence(file, contestantId, evidenceType) {
        if (!file.type.match(/^video\/.*/)) {
            return false;
        }

        const cancel = axios.CancelToken.source();
        const withCancel = {cancelToken: cancel.token};
        const evidence = new Evidence(null, null, file.name);
        const $evidenceView = evidence.makeView($(this).find('ul'), cancelEvidence(cancel));
        const $progressBar = $evidenceView.find('.progress-bar');

        axios.post('contestants/' + contestantId + '/evidence', {
            type: evidenceType,
            filename: file.name,
        }, withCancel)
            .then((response) => {
                $evidenceView.data('id', response.data.evidenceId);

                const data = new FormData();
                for (let field in response.data.upload.fields) {
                    if (response.data.upload.fields.hasOwnProperty(field)) {
                        data.append(field, response.data.upload.fields[field]);
                    }
                }
                data.append('file', file);
                axios.post(response.data.upload.url, data, trackProgress($progressBar, withCancel))
                    .then(() => {
                        axios.patch('contestants/' + contestantId + '/evidence/' + response.data.evidenceId, {
                            status: 'present',
                        }, withCancel)
                            .then(() => {
                                $evidenceView.find('.progress').remove();
                            })
                            .catch(handleErrorWithEvidence($evidenceView));
                    })
                    .catch(handleErrorWithEvidence($evidenceView));
            })
            .catch(handleErrorWithEvidence($evidenceView));
        return true;
    }

    function trackProgress($progressBar, options) {
        return {
            ...options,
            onUploadProgress: progressEvent => {
                $progressBar.css('width', Math.round((progressEvent.loaded * 100) / progressEvent.total) + '%');
            },
        };
    }
}

// prevent the browser from displaying the file when dropping a file (accidentally) outside of a drop zone
function preventNavigationOnDrop() {
    addEventListener('drop', (event) => event.preventDefault());
    addEventListener('dragenter', (event) => event.preventDefault());
    addEventListener('dragover', (event) => event.preventDefault());
    addEventListener('dragleave', (event) => event.preventDefault());
}

function initDeleteEvidence() {
    $deleteEvidenceModal = $('#deleteEvidenceModal');
    $deleteEvidenceModal.find('[data-action]').on('click', function () {
        $deleteEvidenceModal.modal('hide');
        deleteEvidence($deleteEvidenceModal.$evidence);
    });

    $('.delete-evidence').on('click', function () {
        confirmDeleteEvidence($(this).parents('[data-id]'))
    });
}

// when evidence is dropped, link it to
function initLinkEvidence() {
    $('.videos').on('drop', function (event) {
        const $this = $(this);
        const evidence = Evidence.parse(event.originalEvent.dataTransfer.getData('application/x-egoi-evidence'));
        if (evidence && canAcceptEvidence($this, evidence)) {
            const contestantId = $(this).parents('[data-contestant-id]').data('contestantId');
            const $evidenceView = evidence.makeView($this, cancelEvidence(null));
            const $progressBar = $evidenceView.find('.progress');
            axios.post('contestants/' + contestantId + '/evidence/link', {evidenceId: evidence.id})
                .then(() => $progressBar.remove())
                .catch(handleErrorWithEvidence($evidenceView));
        }
    });

    addEventListener('dragstart', function (event) {
        const $evidence = $(event.originalTarget);
        const evidence = new Evidence(
            $evidence.data('id'),
            $evidence.parents('[data-evidence-type]').data('evidenceType'),
            $evidence.find('[data-evidence]').text(),
        );
        event.dataTransfer.setData('application/x-egoi-evidence', evidence.stringify());
        event.dataTransfer.dropEffect = 'link';
    });
}

export default function initDelegation() {
    initAcceptEvidence();
    initUploadEvidence();
    initDeleteEvidence();
    initLinkEvidence();
    preventNavigationOnDrop();
}
