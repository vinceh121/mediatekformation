import { deleteFormation } from '../admin';
import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import language from 'datatables.net-plugins/i18n/fr-FR';

$(() => {
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

	$('.delete-formation').on('click', (e) => {
		e.preventDefault();

		const { formationId, formationName } = e.target.dataset;

		deleteFormation(formationId, formationName).then(_ => {
			tblFormations.row(`tr[data-id="${formationId}"]`).remove();
			tblFormations.draw();
		});
	});
});
