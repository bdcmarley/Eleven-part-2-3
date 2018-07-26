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
            name: [],
            offer: '',
        };
    }

// Tout d'abord on recupere les informations de l'offre pour les avoirs sous nos yeux.
    componentDidMount() {
      var url = window.location.href.split('/');
      url = '/offers/' + url[4];
        axios.get(url)
            .then(result => {
                this.setState({ offer: result.data });
                            });
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
        // lors d'une modification, la methode est un PUT.
          axios.put('/offers/' + this.state.offer.id + '/edit', doc)
              .then(response => {
                  this.setState({
                      error: response.data.error || [],
                      success: response.data.error ? [] : ['Offer modified']
                      // Si tout se passe bien, la page est recharge avec les nouvelles valeurs.
                  });
              });
    }

// Pour nous simplifier la vie, cette function prend en parametre 2 arguments :
// le premier est le type d'input que vous voulez.
// le deuxieme est tout simplement le name.
// Il nous suffit juste de l'apeller pour faire nos inputs.
    formInput(type, name)
    {
      return (
      <FormGroup>
          <ControlLabel>{name}</ControlLabel>
          <FormControl
              type={type}
              name={name}
              id={'exemple'+name}
              placeholder={name}
              inputRef={ input => this[name] = input }
          />
        </FormGroup>
        );
    }

    render() {
      // Ici on refait un formulaire comme pour le create.
      // Lors de la validation de celui-ci, la methode ValidateForm s'enclenche.
        return (
            <div>
                <Form inline onSubmit={ (e) => this.validateForm(e) } >
                    <Error messages={this.state.error}/>
                    <Success messages={this.state.success}/>
                    <h1>{this.state.offer.title}</h1>
                    {this.formInput('text', 'title')}
                    <p>{this.state.offer.content}</p>
                    {this.formInput('text', 'content')}
                    <h3>{this.state.offer.description}</h3>
                    {this.formInput('text', 'description')}
                    <h3>{this.state.offer.price}</h3>
                    {this.formInput('number', 'price')}
                    <Button type="submit">Submit</Button>
                </Form>
                <a href={`/offers/${this.state.offer.id}`}>show</a>
            </div>

        );
    }
}

export default Change;
