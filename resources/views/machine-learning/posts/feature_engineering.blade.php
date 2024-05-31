<x-machine-learning_layout>


    <div class="container-fluid custom-homepage-container">


        <div class="row justify-content-center">
            <div class="col-md-6"> <!-- Adjust the column width as needed -->

                <div class="p-4 custom-card-container" >
                    <h1> Feature Engineering</h1>
               
                    <p>
                    A data scientist has many machine learning tools at their disposal and given a large amount of data, most scientists can train models that return great results. 
                    It is when there is a limited amount of data that an expert data scientist can separate themselves from the less experienced. 
                    In this case, there is more skill required to choose the right features and algorithm such that the trained model will generalize to new data. 
                    </p>

                    <p>
                    As an extreme case, consider the example of fitting quadratic data. 
                    If we have any intuition for the problem, some might blindly choose a couple common models like linear regression or random forest to see which performs better.
                    In this case, the ensemble model performs x3 better in the cross-validation error.  
                    However, neither model truly captures the behavior of the data, and given new data outside our training set both models will generalize poorly. 
                    A little bit of feature engineering can reduce our reliance on model complexity. 
                    For example, there might be a compelling argument for the relationship to be nonlinear and we could incorporate higher order polynomial terms. 
                    </p>

                    <div style="padding:10;">
                        <img class="custom-screenshot" src="{{ asset('images/posts/feature_engineering/model_fitting.jpg') }}" alt="Image 1" width="500" height='auto'> 
                    </div>

                    <p>
                    Physics relies almost entirely on feature engineering to achieve simple, understandable models of the physical world. 
                    A good example is the modeling of wave dispersion. 
                    Dispersion causes the shape of a wave to become distorted and can occur with light, sound, and even water (tsunami!) waves. 
                    Specifically, I dealt with dispersion of light waves in waveguides (a metal pipe to keep the light focused).
                    </p>

                    <div style="padding:10;">
                        <img class="custom-screenshot" src="{{ asset('images/posts/feature_engineering/dispersion.jpg') }}" alt="Image 1" width="500" height='auto'> 

                        <img class="custom-screenshot" src="{{ asset('images/posts/feature_engineering/frequency_components.jpg') }}" alt="Image 1" width="500" height='auto'> 

                    </div>


                    <p>
                    My research focused on optimizing the efficiency of devices called Free Electron Lasers, where the large amount of energy in a relativistic electron beam is converted to powerful, coherent laser pulses by bending the electrons in magnetic fields. 
                    A waveguide was necessary to keep the THz radiation focused so it would continue to interact with the electron beam. 
                    Particle accelerators are complicated and expensive to run, so we rely on accurate particle codes to simulate and design experiments. 
                    While various codes have been developed for specific regimes, few can simulation dispersion in a waveguide.
                    </p>

                    <p>
                    Thinking in machine learning terms, we might consider a brute force approach where the y-values of our data points make up the feature vector, but it would prove difficult to find meaningful results that would generalize well. 
                    Taking a hint from forecasting models, we could instead try and identify or remove the periodicity of the signal. 
                    This is similar to Fourier analysis, where we represent the waveform as the sum of many sinusoidal waves of different frequencies. 
                    In this “frequency” basis, it turns out a simple linear regression model completely explains the distortion. 
                    The final explanation is simple: different frequencies travel at difference speeds! 
                    Once you understand the relationship between frequency and speed, you can perfectly predict the distortion of the waveform. 
                    This last picture shows an experimental measurement of that relationship for waves on a tensioned string (used to correct dispersion in pulsed-wire magnetic field measurements).
                    </p>
                    <div style="padding:10;">
                        <img class="custom-screenshot" src="{{ asset('images/posts/feature_engineering/dispersion_measurement.jpg') }}" alt="Image 1" width="500" height='auto'> 
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-machine-learning_layout>