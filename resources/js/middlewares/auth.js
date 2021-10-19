import { verifyAuth } from "../Api";

export default function auth(next) {
    if (!localStorage.getItem("token")) {
        return next({
            name: "unauthorized"
        });
    }
    verifyAuth()
        .then(() => {
            next();
        })
        .catch(() => {
            localStorage.removeItem("token");
            next({
                name: "unauthorized"
            });
        });

    return next();
}
