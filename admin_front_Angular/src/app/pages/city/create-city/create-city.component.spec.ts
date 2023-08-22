import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateCityComponent } from './create-city.component';

describe('CreateCityComponent', () => {
  let component: CreateCityComponent;
  let fixture: ComponentFixture<CreateCityComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateCityComponent]
    });
    fixture = TestBed.createComponent(CreateCityComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
