import { deleteModal, showToast } from '../admin';
import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import language from 'datatables.net-plugins/i18n/fr-FR';

$(() => {
	$('.delete-formation').on('click', (e) => {
		e.preventDefault();

		const { formationId, formationName } = e.target.dataset;

		deleteModal(`Supprimer la formation ${formationName} ?`, 'Supprimer formation ?').then(async _ => {
			const res = await fetch('/admin/formation/' + formationId, { method: 'DELETE' });

			if (res.status !== 200) {
				const { error } = await res.json();
				showToast(error, `Erreur dans la suppression de la formation`, 'danger');
				return;
			}

			tblFormations.row(`tr[data-id="${formationId}"]`).remove();
			tblFormations.draw();
		});
	});

	$('.delete-playlist').on('click', (e) => {
		e.preventDefault();

		const { playlistId, playlistName } = e.target.dataset;

		deleteModal(`Supprimer la playlist ${playlistName} ?`, 'Supprimer playlist ?').then(async _ => {
			const res = await fetch('/admin/playlist/' + playlistId, { method: 'DELETE' });

			if (res.status !== 200) {
				const { error } = await res.json();
				showToast(error, 'Erreur dans la suppression de la playlist', 'danger');
				return;
			}

			tblPlaylists.row(`tr[data-id="${playlistId}"]`).remove();
			tblPlaylists.draw();
		});
	});
	
	$('.delete-category').on('click', (e) => {
		e.preventDefault();

		const { categoryId, categoryName } = e.target.dataset;

		deleteModal(`Supprimer la catégorie ${categoryName} ?`, 'Supprimer catégorie ?').then(async _ => {
			const res = await fetch('/admin/category/' + categoryId, { method: 'DELETE' });

			if (res.status !== 200) {
				const { error } = await res.json();
				showToast(error, 'Erreur dans la suppression de la catégorie', 'danger');
				return;
			}

			tblCategories.row(`tr[data-id="${categoryId}"]`).remove();
			tblCategories.draw();
		});
	});

	const tblFormations = new DataTable('#tblFormations', {
		language,
		order: [[3, 'desc']],
		columnDefs: [
			{
				target: 4,
				orderable: false
			},
			{
				target: 5,
				orderable: false
			},
			{
				target: 6,
				orderable: false
			}
		]
	});

	const tblPlaylists = new DataTable('#tblPlaylists', {
		language,
		order: [[2, 'desc']],
		columnDefs: [
			{
				target: 3,
				orderable: false
			}
		]
	});

	const tblCategories = new DataTable('#tblCategories', {
		language
	});
});
