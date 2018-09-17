const postProxyHandler = {
    set(object, prop, value) {
        const watch_fields = ['category_id'];
        if(watch_fields.includes(prop)) {
            object.is_dirty = true;
        }
        return Reflect.set(...arguments);
    }
};

export {postProxyHandler};