import React from 'react';
import axios from 'axios';

import Error from 'containers/Alert/Error';
import Success from 'containers/Alert/Success';

import {
    FormGroup,
    ControlLabel,
    FormControl,
    Form,
    Button, } from 'react-bootstrap';

// Ici, on s'occupe de la modification d'une offre.
class Change extends React.Component {

    constructor(){
        super();

        this.state = {
            error: [],
            success: [],
            offer: {
                title: '',
                content: '',
                description: '',
                price: ''
            },
        };
        this.handleChange = this.handleChange.bind(this);
    }

// Tout d'abord on recupere les informations de l'offre pour les avoirs sous nos yeux.
    componentDidMount() {
        if(this.state.offer.title == '')
        {
            var url = window.location.href.split('/');
            url = '/offers/' + url[4];
            axios.get(url)
            .then(result => {
                this.setState({ offer: result.data });
            });
        }
    }


    // Lors de la validation du formulaire, cette methode se declanche.
    validateForm() {
        // On reunit les valeurs entrees par l'utilisateur.
        var doc = {
            title: this.title.value,
            content: this.content.value,
            description: this.description.value,
            price: this.price.value
        };
        // lors d'une modification, la methode est PUT.
        var url = window.location.href.split('/');
        url = '/offers/' + url[4];
        axios.put(url + '/edit', doc)
        .then(response => {
            this.setState({
                // Si tout se passe bien, la page est recharge avec les nouvelles valeurs.
                error: response.data.error || [],
                success: response.data.error ? [] : ['Offer modified']
            });
        });
    }

    // Pour nous simplifier la vie, cette function prend en parametre 2 arguments :
    // le premier est le type d'input que vous voulez.
    // le deuxieme est tout simplement le name.
    // Il nous suffit juste de l'apeller pour faire nos inputs.
    formInput(type, name, value)
    {
        return (
            <FormGroup>
            <ControlLabel>{name}</ControlLabel>
            <FormControl
                type={type}
                name={name}
                value={value}
                id={'exemple'+name}
                inputRef={ input => this[name] = input }
                onChange={this.handleChange(name).bind(this)}
             />
           </FormGroup>
         );
    }

    // A chaque evenement, on change la valeur du state tape dans l'input.
    handleChange(fieldName)
    {
        return function (event)
        {
            this.setState({offer: {
                [fieldName]: event.target.value}});
        };
    }

    render() {
        // Ici on refait un formulaire comme pour le create.
        // On preremplit les value avec celle existantes.
        // Lors de la validation de celui-ci, la methode ValidateForm s'enclenche.
        return (
            <div>
                <Form inline onSubmit={ (e) => this.validateForm(e) } >
                    <Error messages={this.state.error}/>
                    <Success messages={this.state.success}/>
                    {this.formInput('text', 'title', this.state.offer.title)}
                    {this.formInput('text', 'content', this.state.offer.content)}
                    {this.formInput('text', 'description', this.state.offer.description)}
                    {this.formInput('number', 'price', this.state.offer.price)}
                    <Button type="submit">Submit</Button>
                </Form>
                <a href={`/offers/${this.state.offer.id}`}>show</a>
            </div>
        );
    }
}
export default Change;
