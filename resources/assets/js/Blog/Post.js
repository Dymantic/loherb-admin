class Post {
    constructor(
        {
            id = null,
            title = { en: "", zh: "" },
            intro = { en: "", zh: "" },
            description = { en: "", zh: "" },
            body = { en: "", zh: "" },
            is_draft = true,
            title_image_original,
            title_image_banner,
            title_image_web,
            title_image_thumb,
            created_at,
            updated_at,
            publish_date,
            first_published_on,
            categories = []
        },
        langs = ["en", "zh"]
    ) {
        this.id = id;
        this.title = title;
        this.intro = intro;
        this.description = description;
        this.body = body;
        this.is_draft = is_draft;
        this.title_image_original = title_image_original;
        this.title_image_banner = title_image_banner;
        this.title_image_web = title_image_web;
        this.title_image_thumb = title_image_thumb;
        this.created_at = created_at;
        this.updated_at = updated_at;
        this.publish_date = publish_date;
        this.first_published_on = first_published_on;
        this.categories = categories;
        this.category_id = categories.map(cat => cat.id);

        langs.forEach(lang => {
            this.title[lang] =
                this.title[lang] === undefined ? "" : this.title[lang];
            this.description[lang] =
                this.description[lang] === undefined
                    ? ""
                    : this.description[lang];
            this.intro[lang] =
                this.intro[lang] === undefined ? "" : this.intro[lang];
            this.body[lang] =
                this.body[lang] === undefined ? "" : this.body[lang];
        });
    }
}

export { Post };
