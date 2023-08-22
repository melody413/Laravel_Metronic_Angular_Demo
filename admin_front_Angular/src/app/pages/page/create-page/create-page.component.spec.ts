import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreatePageComponent } from './create-page.component';

describe('CreatePageComponent', () => {
  let component: CreatePageComponent;
  let fixture: ComponentFixture<CreatePageComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreatePageComponent]
    });
    fixture = TestBed.createComponent(CreatePageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
