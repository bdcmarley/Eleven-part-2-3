// En premier lieu, dans React, nous avons affaire a ce premiere index ou nous allons pouvoir etablir nos routes.
// On importe les librairies concernes.

// React - ReactDOM
import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Switch, Route } from 'react-router-dom';
import axios from 'axios';

// Puis les pages concernes.

// Components
import Offers from 'components/Page/Offers';
import OffersC from 'components/Page/Offers/create';
import OffersS from 'components/Page/Offers/show';
import OffersP from 'components/Page/Offers/change';

// Un petit peu de CSS.

// css
import 'bootstrap/dist/css/bootstrap.css';
import './style.scss';

// Grace a axios, on va pouvoir nomme la base du lien de notre API par default.
// On sera donc pas oblige de mettre tout l'url mais seulement le bout de routes de l'action concerne.
axios.defaults.baseURL = 'http://localhost:8000';

// Voici notre premiere methode render, elle est presente dans tout les components React.
// Ici, elle nous sert justte a etablir nos routes. 
ReactDOM.render(
    <Router>
        <Switch>
            <Route exact path="/offers" component={ Offers } />
            <Route exact path="/create_offers" component={ OffersC } />
            <Route exact path="/offers/:id" component={ OffersS } />
            <Route exact path="/change_offers/:id" component={ OffersP } />
        </Switch>
    </Router>
    , document.getElementById('react')
);
