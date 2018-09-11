import axios from "axios";
import { Post } from "./Post";

const postRepo = {
    fetch(postId) {
        return new Promise((resolve, reject) => {
            axios
                .get(`/multilingual-posts/posts/${postId}`)
                .then(({ data }) => resolve(new Post(data)))
                .catch(err => reject(err.response));
        });
    },

    save(post) {
        return new Promise((resolve, reject) => {
            axios
                .post(`/multilingual-posts/posts/${post.id}`, {
                    title: post.title,
                    intro: post.intro,
                    description: post.description,
                    body: post.body,
                    category_id: post.category_id
                })
                .then(() => resolve())
                .catch(err => reject(err.response));
        });
    }
};

export { postRepo };
