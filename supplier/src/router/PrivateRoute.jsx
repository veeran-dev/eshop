import React from 'react'

const PrivateRoute = ({component: Component, ...rest}) => {
  const {isLogged} = rest;

  return (
    <Route {...rest} render={props => (
      isLogged ? (
        <Component {...props}/>
      ) : (
        <Redirect to={{
          pathname: '/login'
        }}/>
      )
    )}
    />
  );
};

PrivateRoute.propTypes = {
  isLogged: PropTypes.bool.isRequired,
};

// function mapStateToProps(state) {
//   return {
//     isLogged: state.user.isLogged,
//   };
// }

// export default connect(mapStateToProps)(PrivateRoute;

export default PrivateRoute;