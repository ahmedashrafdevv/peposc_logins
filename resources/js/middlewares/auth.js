import { verifyAuth } from "../Api";

export default function auth(next) {
    if (!localStorage.getItem("token")) {
        return next({
            name: "unauthorized"
        });
    }
    // verify auth is a simple check to approve that the token is valid
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
