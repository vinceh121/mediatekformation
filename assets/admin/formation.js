import { deleteFormation } from '../admin';
import $ from 'jquery';

$(document).ready(() => {
	$('.delete-formation').on('click', (e) => {
		e.preventDefault();

		const { formationId, formationName } = e.target.dataset;

		deleteFormation(formationId, formationName).then(_ => location = '/admin');
	});
});
