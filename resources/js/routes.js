const Dashboard = () => import("./components/Dashboard");
const Login = () => import("./components/Login");
const Register = () => import("./components/Register");
const Authors = () => import("./components/Authors/AuthorsTable");
const Author = () => import("./components/Authors/CreateAuthor");
const Categories = () => import("./components/Categories/CategoriesTable");
const Category = () => import("./components/Categories/CreateCategory");

const routes = [
    {
        path: "/",
        redirect: "/dashboard",
    },
    {
        path: "/dashboard",
        component: Dashboard,
    },
    {
        name: "login",
        path: "/login",
        component: Login,
    },
    {
        name: "Register",
        path: "/register",
        component: Register,
    },
    {
        name: "Authors",
        path: "/authors",
        component: Authors,
    },
    {
        name: "Author",
        path: "/author",
        component: Author,
    },
    {
        name: "Categories",
        path: "/categories",
        component: Categories,
    },
    {
        name: "Category",
        path: "/Category",
        component: Category,
    },
];

export default routes;
