import '../admin';
import $ from 'jquery';
import DataTable from 'datatables.net-bs5';
import language from 'datatables.net-plugins/i18n/fr-FR';

$(document).ready(() => {
	const tblFormations = new DataTable('#tblFormations', {
		language: language,
		order: [[2, 'desc']],
		columnDefs: [
			{
				target: 3,
				orderable: false
			},
			{
				target: 4,
				orderable: false
			},
			{
				target: 5,
				orderable: false
			}
		]
	});
});
