import { deleteModal, showToast } from '../admin';
import $ from 'jquery';

$(() => {
	$('.delete-category').on('click', (e) => {
		e.preventDefault();

		const { categoryId, categoryName } = e.target.dataset;

		deleteModal(`Supprimer la catégorie ${categoryName}`, 'Supprimer catégorie ?').then(async _ => {
			const res = await fetch('/admin/category/' + categoryId, { method: 'DELETE' });

			if (res.status !== 200) {
				const { error } = await res.json();
				showToast(error, 'Erreur dans la suppression de la catégorie', 'danger');
				return;
			}

			location = '/admin';
		});
	});
});
