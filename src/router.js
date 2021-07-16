import Vue from 'vue'
import Router from 'vue-router'
import NuevaReceta from '@/components/NuevaReceta'
import Recetas from '@/components/Recetas'
import Recetario from '@/components/Recetario'

Vue.use(Router);

export default new Router({
    routes: [{
        path: '/nueva-receta',
        name: 'NuevaReceta',
        component: NuevaReceta
    },
    {
        path: '/recetas',
        name: 'Recetas',
        component: Recetas,
    },
    {
        path: '/',
        name: 'Recetario',
        component: Recetario,
    },
    ]
});