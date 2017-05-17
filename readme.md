### How to..

A few commands to make this app works:


1. Scrape themes:

```
*  php artisan scrape:theme --provider=wordpress
```

You can also specify the page range you want to scrape by using the `--page=1-5` flag.


2. Scrape plugin:

```
* php artisan scrape:plugin --provider=wordpress
```

The provider parameter is compulsory. So far only two providers have been implemented. (wordpress&themeforest)

3. Find Theme alias, screenshot for existing records:

```
* php artisan detect:ThemeMeta
```

---
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/00cbfe0b-1cae-4886-aca7-e5b292228347/mini.png)](https://insight.sensiolabs.com/projects/00cbfe0b-1cae-4886-aca7-e5b292228347)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/youhackme/Toggle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/youhackme/Toggle/?branch=master)
