class Post {
    constructor({id = null, title = {en: "", zh: ""}, intro = {en: "", zh: ""}, description = {en: "", zh: ""}, body = {en: "", zh: ""}}, langs = ['en', 'zh']) {
        this.id = id;
        this.title = title;
        this.intro = intro;
        this.description = description;
        this.body = body;

        langs.forEach(lang => {
            this.title[lang] = this.title[lang] === undefined ? "" : this.title[lang];
            this.description[lang] = this.description[lang] === undefined ? "" : this.description[lang];
            this.intro[lang] = this.intro[lang] === undefined ? "" : this.intro[lang];
            this.body[lang] = this.body[lang] === undefined ? "" : this.body[lang];
        });
    }
}

export {Post};