const BooksTable = () => import("./components/Books/BooksTable");
const Login = () => import("./components/Login");
const Register = () => import("./components/Register");
const Authors = () => import("./components/Authors/AuthorsTable");
const Author = () => import("./components/Authors/CreateAuthor");
const Categories = () => import("./components/Categories/CategoriesTable");
const Category = () => import("./components/Categories/CreateCategory");
const UsersTable = () => import("./components/Users/UsersTable");
import store from "./store";

const routes = [
    {
        path: "/",
        redirect: "/books",
    },
    {
        path: "/books",
        component: BooksTable,
    },
    {
        name: "login",
        path: "/login",
        component: Login,
    },
    {
        name: "Users",
        path: "/users",
        component: UsersTable,
        beforeEnter: (to, from, next) => {
            if (store.state.isAdmin) {
                next();
            }
            return false;
        },
    },
    {
        name: "Register",
        path: "/register",
        component: Register,
        beforeEnter: (to, from, next) => {
            if (store.state.isAdmin) {
                next();
            }
            return false;
        },
    },
    {
        name: "Authors",
        path: "/authors",
        component: Authors,
        beforeEnter: (to, from, next) => {
            if (store.state.isAdmin) {
                next();
            }
            return false;
        },
    },
    {
        name: "Author",
        path: "/author",
        component: Author,
        beforeEnter: (to, from, next) => {
            if (store.state.isAdmin) {
                next();
            }
            return false;
        },
    },
    {
        name: "Categories",
        path: "/categories",
        component: Categories,
        beforeEnter: (to, from, next) => {
            if (store.state.isAdmin) {
                next();
            }
            return false;
        },
    },
    {
        name: "Category",
        path: "/Category",
        component: Category,
        beforeEnter: (to, from, next) => {
            if (store.state.isAdmin) {
                next();
            }
            return false;
        },
    },
];

export default routes;
