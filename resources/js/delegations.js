import $ from 'jquery';

let $deleteEvidenceModal;

function handleErrorWithEvidence($evidenceView) {
    return thrown => {
        if (!axios.isCancel(thrown)) {
            $evidenceView.find('.progress').remove();
            $evidenceView.addClass('text-danger bg-warning');
        }
    };
}

function cancelEvidence(cancel, $evidenceView) {
    return () => {
        cancel.cancel();
        if ($evidenceView.data('id')) {
            $evidenceView.find('.progress').remove();
            deleteEvidence($evidenceView);
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
        .catch(handleErrorWithEvidence($evidence));
}

function initUploadEvidence() {
    $('.videos').on('drop', function (event) {
        $(this).removeClass('hovered');
        uploadFiles.call(this, event.originalEvent.dataTransfer.files);
    }).on('dragenter', function () {
        $(this).addClass('hovered');
    }).on('dragover', function () {
        $(this).addClass('hovered');
    }).on('dragleave', function () {
        $(this).removeClass('hovered');
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
        const $evidenceView = makeEvidenceView(file.name, $(this).find('ul'), cancel);
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

    function makeEvidenceView(evidenceName, $parent, cancel) {
        const $evidenceView = $('<li class="list-group-item">' +
            '  <span data-evidence></span>' +
            '  <a class="float-right delete-evidence" href="javascript:">×</a>' +
            '  <div class="progress">' +
            '    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0"></div>' +
            '  </div>' +
            '</li>');
        $evidenceView.find('[data-evidence]').text(evidenceName);
        $evidenceView.find('.delete-evidence').on('click', cancelEvidence(cancel, $evidenceView));
        $parent.append($evidenceView);
        return $evidenceView;
    }

    function trackProgress($progressBar, options) {
        return {
            ...options,
            onUploadProgress: progressEvent => {
                $progressBar.css('width', Math.round((progressEvent.loaded * 100) / progressEvent.total) + '%');
            },
        };
    }

    // prevent the browser from displaying the file when dropping a file accidentally outside of a drop zone
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

export default function initDelegation() {
    initUploadEvidence();
    initDeleteEvidence();
}
