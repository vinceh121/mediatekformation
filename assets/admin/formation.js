import { deleteModal } from '../admin';
import $ from 'jquery';

$(() => {
	$('.delete-formation').on('click', (e) => {
		e.preventDefault();

		const { formationId, formationName } = e.target.dataset;

		deleteModal(`Supprimer la formation ${formationName}`, 'Supprimer la formation ?').then(async _ => {
			const res = await fetch('/admin/formation/' + formationId, { method: 'DELETE' });

			if (res.status !== 200) {
				const { error } = await res.json();
				showToast(error, `Erreur dans la suppression de la formation`, 'danger');
				return;
			}

			location = '/admin';
		});
	});

	const videoId = $('#formation_videoId');
	videoId.on('paste', (event) => {
		const paste = (event.originalEvent.clipboardData || window.clipboardData).getData('text');

		if (URL.canParse(paste)) {
			const url = new URL(paste);

			if (['youtube.com', 'www.youtube.com'].includes(url.hostname) && url.pathname === '/watch') {
				event.preventDefault();
				videoId.val(url.searchParams.get('v'));
			} else if (url.hostname === 'youtu.be') {
				event.preventDefault();
				videoId.val(url.pathname.substring(1));
			}
		}
	});
});
