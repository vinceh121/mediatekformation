import '../admin';
import $ from 'jquery';
import Sortable from 'sortablejs';

$(() => {
	const formationsSelect = $('#playlist_formations > option');
	const formationsSort = $('#formationsSort');

	for (const opt of formationsSelect) {
		const img = $('<img>', { src: opt.dataset.thumbnail, alt: $(opt).text(), class: 'p-1' });
		const del = $('<button>', { type: 'button', class: 'btn btn-danger float-end m-1 formation-delete' })
			.append($('<i>', { class: 'bi bi-trash-fill' }));
		const openForm = $('<a>', { type: 'button', class: 'btn btn-secondary float-end m-1 formation-open', target: '_blank' })
			.append($('<i>', { class: 'bi bi-box-arrow-up-right' }));
		const listItem = $('<li>', { class: 'list-group-item list-group-item-action p-1', 'data-id': opt.value })
			.append(img)
			.append($(opt).text())
			.append(del)
			.append(openForm);

		formationsSort.append(listItem);
	}

	const formationsSortable = Sortable.create(formationsSort[0], {
		animation: 350
	});

	$('.formation-delete').on('click', event => {
		$(event.target).parents('li').remove();
	});

	for (const anchor of $('.formation-open')) {
		anchor.href = '/admin/formation/' + $(anchor).parents('li').data('id');
	}

	$('form[name="playlist"]').on('formdata', event => {
		const data = event.originalEvent.formData;

		const order = formationsSortable.toArray();

		for (const id of order) {
			data.append('playlist[formations][]', id);
		}
	});
});
