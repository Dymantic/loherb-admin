import axios from "axios";
import { Post } from "./Post";
import { postProxyHandler } from "./PostProxyHandler";

const postRepo = {
    fetch(postId) {
        return new Promise((resolve, reject) => {
            axios
                .get(`/multilingual-posts/posts/${postId}`)
                .then(({ data }) => {
                    let post = new Post(data);
                    let proxy = new Proxy(post, postProxyHandler);
                    resolve(proxy);
                })
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
