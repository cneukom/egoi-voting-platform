import $ from 'jquery';

class OptionInjector {
    constructor($container) {
        this.$form = $container.parent('form');
        this.$container = $container;
        this.$optionContainerTemplate = $container.find('.form-group').first();
        this.$form.on('submit', () => this.excludeEmptyOptions());
        this.$container.find('input').on('input', () => this.addOptionIfNeeded());
        this.addOptionIfNeeded();
    }

    addOptionIfNeeded() {
        const empty = function () {
            return this.value === '';
        };

        if (this.$container.find('input').filter(empty).length === 0) {
            const $optionContainer = this.$optionContainerTemplate.clone();
            $optionContainer.find('input').val('');
            $optionContainer.on('input', () => this.addOptionIfNeeded());
            this.$container.append($optionContainer);
        }
    }

    excludeEmptyOptions() {
        this.$container.find('input').each(function () {
            if (this.value === '') {
                this.name = '';
            }
        });
    }
}

export default function initAnswerOptions() {
    new OptionInjector($('[data-inject-options]'))
}
