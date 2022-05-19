"use strict"

import {addInputError, removeInputError} from "./colorErrorInputs";

document.addEventListener('DOMContentLoaded', function() {
    const acceptFileFormats = {
        images: ["image/jpeg", "image/gif", "image/png"],
        files: ["text/plain"],
    };
    const form = document.getElementById('form');

    form.addEventListener('submit', sendForm);

    async function sendForm(e) {
        e.preventDefault();

        let errorsCount = validateForm(form);

        let formData = new FormData(form);
        formData.append('file-input', fileInput.files);

        if (errorsCount > 0) {
            alert('Заполните обязательные поля!');
        } else {
            form.classList.add('_sending');
            let response = await fetch('saveCommentToDB.php', {
               method: 'POST',
               body: formData,
            });

            if (response.ok) {
                alert("Успешно сохранено!");
                filePreview.innerHTML = '';
                form.reset();
                form.classList.remove('_sending');
                document.location.reload();
            } else {
                alert("Ошибка!");
                alert(response.errors);
                form.classList.remove('_sending');
            }
        }
    }
    // Проверяем на соответствие требованиям поля формы
    function validateForm(form) {
        let errorsCount = 0;
        let requiredFields = document.querySelectorAll('._required');

        for (let index = 0; index < requiredFields.length; index++) {
            const input = requiredFields[index]
            removeInputError(input);

            if (input.classList.contains('_email')) {
                if (testEmail(input)) {
                    addInputError(input);
                    errorsCount++;
                }
            } else if (input.classList.contains('_homepage')) {
                if (testHomepage(input)) {
                    addInputError(input);
                    errorsCount++;
                }
            } else {
                if (input.value.length === 0) {
                    addInputError(input);
                    errorsCount++;
                }
            }
        }

        return errorsCount;
    }

    function testEmail(input) {
        return !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value);
    }

    function testHomepage(input) {
        return "^http(s)?://([\w-]+.)+[\w-]+(/[\w- ./?%&=])?$/".test(input.value);
    }

    // Алгоритм обработки файла и отображения превью
    const fileInput = document.getElementById('file-input');
    const filePreview = document.getElementById('file-preview');

    fileInput.addEventListener('change', () => {
       uploadFile(fileInput.files[0]);
    });

    function uploadFile(file) {
        let errorMessage = ``;
        // Проверяем формат файла
        if (!acceptFileFormats.files.includes(file.type) && !acceptFileFormats.images.includes(file.type)) {
            errorMessage += `Неподходящий формат файла!\nРазрешённые форматы изображений: ${acceptFileFormats.images}\nРазрешенные форматы файлов:${acceptFileFormats.files}\n`;
        }

        if (acceptFileFormats.files.includes(file.type)) {
            if (file.size > 100 * 1024) {// Размер файла не больше 100 КБ
                errorMessage += `Слишком тяжёлый файл!\nМаксимальный вес файла - 100 КБ\n`;
            }
        } else if (acceptFileFormats.images.includes((file.type))) {
            if (file.size > 2 * 1024 * 1024) {// Вес картинки не больше 2 МБ
                errorMessage += `Слишком тяжёлая картинка!\nМаксимальный вес картинки - 2 МБ\n`;
            }
        }

        if (errorMessage.length > 0) {
            alert(errorMessage);
            fileInput.value = '';
            return;
        }
        //Отображаем preview
        let reader = new FileReader();
        reader.onload = function (e) {
            if (acceptFileFormats.images.includes(file.type)) {
                filePreview.innerHTML = `<img src="${e.target.result}" alt="Photo" class="preview-image">`;
            } else {
                filePreview.innerHTML = `<img src="./images/txt-image.webp" alt="TXT File" class="preview-file-image">`;
            }

        };
        reader.onerror = function (e) {
            alert('Ошибка загрузки файла!');
        }
        reader.readAsDataURL(file);
    }
});