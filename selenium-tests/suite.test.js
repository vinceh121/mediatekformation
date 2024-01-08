const { Builder, By } = require("selenium-webdriver");
const chrome = require("selenium-webdriver/chrome");
const firefox = require("selenium-webdriver/firefox");

const { BROWSER, BASE_URL } = process.env;

/**
 * @type {import("selenium-webdriver").ThenableWebDriver}
 */
let driver;
beforeAll(async () => {
	driver = await new Builder().forBrowser(BROWSER)
		.setChromeOptions(new chrome.Options()
			.addArguments("--headless")
			.addArguments("--window-size=1920,1080"))
		.setFirefoxOptions(new firefox.Options()
			.addArguments("--headless"))
		.build();
}, 10_000);

it("should navigate to home", async () => {
	await driver.get(BASE_URL + "/");
	expect(await driver.getTitle()).toBe(""); // TODO set a title
});

it("should navigate to formations using navbar", async () => {
	await driver.get(BASE_URL + "/");
	const anchor = await driver.findElement(By.css('.nav-link[href="/formations"]'));
	await anchor.click();
	expect(await driver.getCurrentUrl()).toContain("/formations");
	expect(await driver.getTitle()).toBe(""); // TODO set a title
});

it("should sort formations by title", async () => {
	await driver.get(BASE_URL + "/formations");
	await (await driver.findElement(By.css('a[href="/formations/tri/title/DESC"]'))).click();
	expect(await driver.getCurrentUrl()).toContain("/formations/tri/title/DESC");

	const firstFormation = await driver.findElement(By.css("tbody tr h5"));
	expect(await firstFormation.getText()).toBe("title 3");
});

it("should sort formations by date", async () => {
	await driver.get(BASE_URL + "/formations");
	await (await driver.findElement(By.css('a[href="/formations/tri/publishedAt/DESC"]'))).click();
	expect(await driver.getCurrentUrl()).toContain("/formations/tri/publishedAt/DESC");

	const firstFormation = await driver.findElement(By.css("tbody tr h5"));
	expect(await firstFormation.getText()).toBe("title 3");
});

it("should search formations by title", async () => {
	await driver.get(BASE_URL + "/formations");
	const searchBar = await driver.findElement(By.css('form[action="/formations/recherche/title"] input'));
	searchBar.sendKeys("title 2");

	const searchButton = await driver.findElement(By.css('form[action="/formations/recherche/title"] button'));
	await searchButton.click();

	expect(await driver.getCurrentUrl()).toContain("/formations/recherche/title");

	const firstFormation = await driver.findElement(By.css("tbody tr h5"));
	expect(await firstFormation.getText()).toBe("title 2");
});

it("should navigate to playlists by navbar", async () => {
	await driver.get(BASE_URL + "/");
	const anchor = await driver.findElement(By.css('.nav-link[href="/playlists"]'));
	await anchor.click();

	expect(await driver.getCurrentUrl()).toContain("/playlists");
	expect(await driver.getTitle()).toBe(""); // TODO set a title
});

it("should navigate to specific playlist", async () => {
	await driver.get(BASE_URL + "/playlists");
	const anchor = await driver.findElement(By.css('.btn[href^="/playlists/playlist/"]'));
	await anchor.click();

	expect(await driver.getCurrentUrl()).toContain("/playlists/playlist/");
	expect(await driver.getTitle()).toBe(""); // TODO set a title

	const playlistTitle = await driver.findElement(By.css('h4, .text-info'));
	expect(await playlistTitle.getText()).toBe("My playlist");
});
