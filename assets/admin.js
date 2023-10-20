import './app';
import './styles/admin.css';
import $ from 'jquery';
import { Modal } from 'bootstrap';

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
