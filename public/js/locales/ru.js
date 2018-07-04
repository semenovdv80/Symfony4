/*!
 * FileInput <_LANG_> Translations
 *
 * This file must be loaded after 'fileinput.js'. Patterns in braces '{}', or
 * any HTML markup tags in the messages must not be converted or translated.
 *
 * @see http://github.com/kartik-v/bootstrap-fileinput
 *
 * NOTE: this file must be saved in UTF-8 encoding.
 */
(function ($) {
    "use strict";

    $.fn.fileinputLocales['ru'] = {
        fileSingle: 'файл',
        filePlural: 'файлы',
        browseLabel: 'Обзор &hellip;',
        removeLabel: 'Убрать',
        removeTitle: 'Очистить выбранные файлы',
        cancelLabel: 'Отмена',
        cancelTitle: 'Прервать непрерывную загрузку',
        uploadLabel: 'Загрузка',
        uploadTitle: 'Загрузить указанные файлы',
        msgNo: 'Нет',
        msgNoFilesSelected: 'Файлы не добавлены',
        msgCancelled: 'Отменено',
        msgZoomModalHeading: 'Предварительный просмотр',
        msgSizeTooSmall: 'Файл "{name}" (<b>{size} KB</b>) слишком мал, минимальный размер файла <b>{minSize} KB</b>.',
        msgSizeTooLarge: 'Файл "{name}" (<b>{size} KB</b>) превышает допустимый лимит в <b>{maxSize} KB</b>.',
        msgFilesTooLess: 'You must select at least <b>{n}</b> {files} to upload.',
        msgFilesTooMany: 'Количество загружаемых файлов <b>({n})</b> превышает максимально допустимое <b>{m}</b>.',
        msgFileNotFound: 'Файл "{name}" не найден!',
        msgFileSecured: 'Ограничения безопасности предотвращают чтение файла "{name}".',
        msgFileNotReadable: 'Файл "{name}" не удается прочесть.',
        msgFilePreviewAborted: 'Предварительный просмотр файла прерван для "{name}".',
        msgFilePreviewError: 'An error occurred while reading the file "{name}".',
        msgInvalidFileName: 'Invalid or unsupported characters in file name "{name}".',
        msgInvalidFileType: 'Недопустимый тип файла "{name}". Только "{types}" файлы которые поддерживаются.',
        msgInvalidFileExtension: 'Недопустимое расширение для файла "{name}". Только "{extensions}" файлы которые поддерживаются.',
        msgFileTypes: {
            'image': 'картинка',
            'html': 'HTML',
            'text': 'текст',
            'video': 'видео',
            'audio': 'аудио',
            'flash': 'flash',
            'pdf': 'PDF',
            'object': 'object'
        },
        msgUploadAborted: 'The file upload was aborted',
        msgUploadThreshold: 'Processing...',
        msgUploadBegin: 'Initializing...',
        msgUploadEnd: 'Done',
        msgUploadEmpty: 'No valid data available for upload.',
        msgValidationError: 'Validation Error',
        msgLoading: 'Loading file {index} of {files} &hellip;',
        msgProgress: 'Loading file {index} of {files} - {name} - {percent}% completed.',
        msgSelected: '{n} {files} selected',
        msgFoldersNotAllowed: 'Drag & drop files only! Skipped {n} dropped folder(s).',
        msgImageWidthSmall: 'Width of image file "{name}" must be at least {size} px.',
        msgImageHeightSmall: 'Height of image file "{name}" must be at least {size} px.',
        msgImageWidthLarge: 'Width of image file "{name}" cannot exceed {size} px.',
        msgImageHeightLarge: 'Height of image file "{name}" cannot exceed {size} px.',
        msgImageResizeError: 'Could not get the image dimensions to resize.',
        msgImageResizeException: 'Error while resizing the image.<pre>{errors}</pre>',
        msgAjaxError: 'Something went wrong with the {operation} operation. Please try again later!',
        msgAjaxProgressError: '{operation} failed',
        ajaxOperations: {
            deleteThumb: 'файл удален',
            uploadThumb: 'файл загружен',
            uploadBatch: 'batch file upload',
            uploadExtra: 'form data upload'
        },
        dropZoneTitle: 'Drag & drop files here &hellip;',
        dropZoneClickTitle: '<br>(or click to select {files})',
        fileActionSettings: {
            removeTitle: 'Убрать файл',
            uploadTitle: 'Загрузить файл',
            zoomTitle: 'Посмотреть детали',
            dragTitle: 'Move / Rearrange',
            indicatorNewTitle: 'Not uploaded yet',
            indicatorSuccessTitle: 'Загружено',
            indicatorErrorTitle: 'Ошибка загрузки',
            indicatorLoadingTitle: 'Загрузка ...'
        },
        previewZoomButtonTitles: {
            prev: 'View previous file',
            next: 'View next file',
            toggleheader: 'Toggle header',
            fullscreen: 'Toggle full screen',
            borderless: 'Toggle borderless mode',
            close: 'Close detailed preview'
        }
    };
})(window.jQuery);