const Dashboard = () => import("./components/Dashboard");
const Login = () => import("./components/Login");
const Register = () => import("./components/Register");
const Authors = () => import("./components/Authors/AuthorsTable");
const Author = () => import("./components/Authors/CreateAuthor");

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
];

export default routes;
