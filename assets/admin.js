import './app';
import './styles/admin.css';
import $ from 'jquery';
import { Modal, Toast } from 'bootstrap';

let toast;

$(() => {
	const elem = $('#toast');

	if (elem) {
		toast = new Toast(elem);
	}
});

export const showToast = (bodyText, toastTitle = '', color = 'info') => {
	const availableColors = ['primary', 'success', 'danger', 'warning', 'info'];

	if (!availableColors.includes(color)) {
		throw new Error(`${color} isn't a valid color`);
	}

	$('#toastBody').text(bodyText);
	$('#toastTitle').text(toastTitle);

	const badge = $('#toastBadge');
	availableColors.forEach(cls => badge.removeClass(cls));
	badge.addClass('bg-' + color);

	toast.show();
};

export const deleteModal = (bodyText, modalTitle) => {
	return new Promise((resolve, reject) => {
		const modal = new Modal($('#deleteModal'));;

		$('#deleteModalBody').text(bodyText);
		$('#deleteModalTitle').text(modalTitle);

		$('#deleteBtn').off('click');
		$('#deleteBtn').on('click', () => {
			modal.hide();
			resolve();
		});

		modal.show();
	});
};
