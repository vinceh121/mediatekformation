import './app';
import './styles/admin.css';
import $ from 'jquery';
import { Modal } from 'bootstrap';

export const deleteFormation = (formationId, formationName) => {
	return new Promise((resolve, reject) => {
		const modal = new Modal($('#formationDeleteModal'));;

		$('#formationDeleteModalBody').text(`Supprimer la formation ${formationName} ?`);

		$('#formationDeleteBtn').off('click');
		$('#formationDeleteBtn').on('click', async () => {
			const res = await fetch('/admin/formation/' + formationId, { method: 'DELETE' });

			if (res.status !== 200) {
				reject(new Error(`Erreur dans la suppression de la formation: ${res.statusText}`));
			}

			modal.hide();
			resolve();
		});

		modal.show();
	});
};
