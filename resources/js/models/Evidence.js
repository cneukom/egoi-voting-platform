import $ from "jquery";

export default class Evidence {
    constructor(id, type, name) {
        this.id = id ?? null;
        this.type = type ?? null;
        this.name = name ?? '';
    }

    makeView($parent, cancel) {
        const $evidenceView = $('<li class="list-group-item" draggable="true"'
            + (this.id ? ' data-id="' + this.id + '"' : '')
            + '>' +
            '  <span data-evidence></span>' +
            '  <a class="float-right delete-evidence" href="javascript:">×</a>' +
            '  <div class="progress">' +
            '    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0"></div>' +
            '  </div>' +
            '</li>');
        if (this.name) {
            $evidenceView.find('[data-evidence]').text(this.name);
        }
        if (this.id) {
            $evidenceView.data('id', this.id);
        }
        $evidenceView.find('.delete-evidence').on('click', () => cancel($evidenceView));
        $parent.append($evidenceView);
        return $evidenceView;
    }

    stringify() {
        return this.type + ':' + this.id + ':' + this.name;
    }

    static parse(str) {
        const matches = str.match(/^(\w+):(\d+):(.*)/);
        if (matches) {
            return new Evidence(parseInt(matches[2]), matches[1], matches[3]);
        }
        return null;
    }
}
