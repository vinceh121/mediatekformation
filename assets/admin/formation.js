import { deleteFormation } from '../admin';
import $ from 'jquery';

$(document).ready(() => {
	$('.delete-formation').on('click', (e) => {
		e.preventDefault();

		const { formationId, formationName } = e.target.dataset;

		deleteFormation(formationId, formationName).then(_ => location = '/admin');
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
