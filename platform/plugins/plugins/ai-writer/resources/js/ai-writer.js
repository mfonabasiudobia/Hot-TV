import initCkEditor from './ckeditor'

class AiWriter {
    constructor() {
        this.$body = $('body')
        this.promptForm = $('#setup-prompt')
        this.spinForm = $('#setup-spin')
        this.generateModal = $('#ai-writer-modal')
        this.spinModal = $('#ai-writer-spin-modal')

        this.handleGenerateEvents()

        if (typeof $spinTemplates !== 'undefined') {
            this.handleSpinEvents()
        }

        this.initEditor()
    }

    initEditor() {
        initCkEditor('preview_content')

        if (typeof $spinTemplates !== 'undefined') {
            initCkEditor('preview_spin_content')
        }
    }

    updateModalState(modal, isLoading) {
        const $btnGenerate = $('#generate-content')
        const $btnPush = $('#push-content-to-target')

        if (isLoading) {
            $btnGenerate.addClass('button-loading')
            $btnPush.prop('disabled', true)
        } else {
            $btnGenerate.removeClass('button-loading')
            $btnPush.prop('disabled', false)
        }
    }

    pushContentToTarget($contentValue, $targetName) {
        if (!$targetName) {
            return
        }

        $contentValue = $contentValue.replace(/(?:\r\n|\r|\n)/g, '<br>')
        const $contentTarget = $('form').find('[name="' + $targetName + '"]')

        $contentTarget.each(function (index, element) {
            const id = element.id || ''

            if (EDITOR.CKEDITOR[id]) {
                EDITOR.CKEDITOR[id].setData($contentValue)
            } else {
                element.value = $contentValue
            }

            Botble.showSuccess($('#push-content-to-target').data('copied-text'))
        })
    }

    handleGenerateEvents() {
        const $self = this
        const $promptForm = $self.promptForm
        const $previewEditor = $promptForm.find('#preview_content')
        const $targetField = $promptForm.find('#target_field')
        const $promptEditor = $promptForm.find('#prompt')
        const $promptLanguage = $promptForm.find('select[name="language"]')

        const $btnGenerate = $('#generate-content')
        const $btnPush = $('#push-content-to-target')

        const renderPrompt = (index = 0) => {
            if ($promptTemplates[index]) {
                $promptEditor.val($promptTemplates[index].content)
            }
        }

        $(document)
            .on('click', '.btn-ai-writer-generate', function (event) {
                event.preventDefault()

                const targetFieldId = $(this).closest('.form-group').find('textarea').prop('id')

                $self.generateModal.find('#target_field').val(targetFieldId)
                $self.generateModal.modal('show')
            })
            .on('change', '#prompt_type', function () {
                renderPrompt($(this).val())
            })

        $btnGenerate.on('click', function (event) {
            event.preventDefault()

            const $current = $(event.currentTarget)
            const $generateUrl = $current.data('generate-url')
            const $promptValue = $promptEditor.val()

            $.ajax({
                url: $generateUrl,
                type: 'POST',
                data: {
                    prompt: $promptValue,
                    language: $promptLanguage.val(),
                },
                beforeSend: () => {
                    $self.updateModalState($self.generateModal, true)
                },
                success: (res) => {
                    if (res.error) {
                        Botble.showError(res.message)
                    } else {
                        const editor = window.EDITOR.CKEDITOR[$previewEditor.prop('id')]
                        editor.setData(res.data.content)
                    }
                },
                error: (data) => {
                    Botble.handleError(data)
                },
                complete: () => {
                    $self.updateModalState($self.generateModal, false)
                },
            })
        })

        $btnPush.on('click', function (event) {
            event.preventDefault()

            const editor = window.EDITOR.CKEDITOR[$previewEditor.prop('id')]
            const $contentValue = editor.getData()
            const $targetName = $targetField.val()

            $self.pushContentToTarget($contentValue, $targetName)
        })

        renderPrompt(0)
    }

    handleSpinEvents() {
        const $self = this
        const $targetField = $self.spinForm.find('#target_spin_field')

        const $spinTemplateTitle = $self.spinForm.find('#spin_template_title')
        const $spinEditor = $self.spinForm.find('#spin')
        const $previewEditor = $self.spinForm.find('#preview_spin_content')

        const $btnSpin = $('#spin-content')
        const $btnPush = $('#push-spin-content-to-target')
        const $btnOpenSpin = $('.btn-ai-writer-spin')
        $self.spinModal.find('.modal-body .loading-spinner').hide()

        const renderSpinTemplate = (index = 0) => {
            if ($spinTemplates[index]) {
                $spinEditor.val($spinTemplates[index]?.content)
            }
        }

        const pushTargetContentToSpin = ($targetName = '') => {
            let $contentValue = ''
            const $previewId = $previewEditor.prop('id')

            if (!$targetName) {
                return
            }
            const $contentTarget = $('form').find(`[name="${$targetName}"]`)
            $contentTarget.each(function (index, element) {
                const id = element.id || ''

                if (EDITOR.CKEDITOR[id]) {
                    $contentValue = EDITOR.CKEDITOR[id].getData($contentValue)
                } else {
                    $contentValue = element.value
                }
            })

            if (EDITOR.CKEDITOR[$previewId]) {
                EDITOR.CKEDITOR[$previewId].setData($contentValue)
            } else {
                $previewEditor.val($contentValue)
            }
        }

        const getSpinTemplate = () => {
            let $spinValue = $spinEditor.val()
            $spinValue = $spinValue
                .split(/\r?\n/)
                .filter((element) => element)
                .map((parents) => {
                    let elements = parents?.slice(1, -1)?.split('|')
                    elements = elements
                        .filter((element) => {
                            element = element?.trim()
                            return element.length
                        })
                        .map((element) => {
                            return element?.trim()
                        })
                    return elements
                })

            return $spinValue
        }

        $btnOpenSpin.on('click', function (event) {
            event.preventDefault()
            const $targetName = $targetField.val()
            pushTargetContentToSpin($targetName)
            $('#ai-writer-spin-modal').modal('show')
        })

        $btnSpin.on('click', function (e) {
            e.preventDefault()
            const $spinValue = getSpinTemplate()
            let $previewValue = $previewEditor.val()
            const $previewId = $previewEditor.prop('id')

            for (const words of $spinValue) {
                for (const item of words) {
                    const regex = new RegExp(item, 'gi')

                    if ($previewValue.match(regex)) {
                        const randomWord = words[Math.floor(Math.random() * words.length)]
                        $previewValue = $previewValue.replace(regex, randomWord)
                    }
                }
            }

            if (EDITOR.CKEDITOR[$previewId]) {
                EDITOR.CKEDITOR[$previewId].setData($previewValue)
            } else {
                $previewEditor.val($previewValue)
            }
        })

        $btnPush.on('click', function (e) {
            e.preventDefault()
            const $contentValue = $previewEditor.val()
            const $targetName = $targetField.val()

            $self.pushContentToTarget($contentValue, $targetName)
        })

        $targetField.on('change', function () {
            const $targetName = $targetField.val()
            pushTargetContentToSpin($targetName)
        })

        $spinTemplateTitle.on('change', function () {
            renderSpinTemplate($(this).val())
        })

        renderSpinTemplate()
    }
}

$(document).ready(() => {
    new AiWriter()
})
