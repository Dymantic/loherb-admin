import axios from "axios";
import {Post} from "./Post";

const postRepo = {
    fetch(postId) {
        return new Promise((resolve, reject) => {
            axios.get(`/blog/posts/${postId}`)
                .then(({data}) => resolve(new Post(data)))
                .catch(err => reject(err.response));
        })
    },

    update(post) {
        return new Promise((resolve, reject) => {
            axios.post(`/blog/posts/${post.id}`, {
                title: post.title,
                intro: post.intro,
                description: post.description,
                body: post.body
            }).then(() => resolve())
            .catch(err => reject(err.response));
        })
    },

    create(post) {
        return new Promise((resolve, reject) => {
            axios.post(`/blog/posts`, {
                title: post.title,
                intro: post.intro,
                description: post.description,
                body: post.body
            }).then(({data}) => resolve(data.id))
                 .catch(err => reject(err.response));
        })
    }
};

export {postRepo};