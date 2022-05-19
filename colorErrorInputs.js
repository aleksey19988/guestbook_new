"use strict"

// Функция для выделения цветом невалидного поля
export function addInputError(input) {
    input.parentElement.classList.add('_error');
    input.classList.add('_error');
}
// Функция для удаления класса "ошибка" с поля ввода
export function removeInputError(input) {
    input.parentElement.classList.remove('_error');
    input.classList.remove('_error');
}