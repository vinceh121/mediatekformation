import '../admin';
import $ from 'jquery';
import Sortable from 'sortablejs';
import { Modal } from 'bootstrap';

$(() => {
	const formationsSelect = $('#playlist_formations > option');
	const formationsSort = $('#formationsSort');
	const formationPickerModal = new Modal($('#formationPickerModal'));;

	const addFormation = ({ id, name, thumbnail }, prepend) => {
		const img = $('<img>', { src: thumbnail, alt: name, class: 'p-1' });
		const del = $('<button>', { type: 'button', class: 'btn btn-danger float-end m-1 formation-delete' })
			.append($('<i>', { class: 'bi bi-trash-fill' }));
		const openForm = $('<a>', { type: 'button', class: 'btn btn-secondary float-end m-1 formation-open', target: '_blank' })
			.append($('<i>', { class: 'bi bi-box-arrow-up-right' }));
		const listItem = $('<li>', { class: 'list-group-item list-group-item-action p-1', 'data-id': id })
			.append(img)
			.append(name)
			.append(del)
			.append(openForm);

		if (prepend) {
			formationsSort.prepend(listItem);
		} else {
			formationsSort.append(listItem);
		}
	};

	for (const opt of formationsSelect) {
		addFormation({ id: opt.value, name: $(opt).text(), thumbnail: opt.dataset.thumbnail });
	}

	for (const anchor of $('.formation-open')) {
		anchor.href = '/admin/formation/' + $(anchor).parents('li').data('id');
	}

	const formationsSortable = Sortable.create(formationsSort[0], {
		animation: 350
	});

	$('.formation-picker-btn').on('click', ({ target, shiftKey }) => {
		addFormation({ id: $(target).data('id'), name: $(target).text(), thumbnail: $(target).data('thumbnail') }, true);
		$(target).remove();

		if (!shiftKey) {
			formationPickerModal.hide();
		}
	});

	$('.formation-delete').on('click', event => {
		$(event.target).parents('li').remove();
	});

	$('#formationAddBtn').on('click', () => {
		formationPickerModal.show();
	});

	$('form[name="playlist"]').on('formdata', event => {
		const data = event.originalEvent.formData;

		const order = formationsSortable.toArray();

		for (const id of order) {
			data.append('playlist[formations][]', id);
		}
	});
});
